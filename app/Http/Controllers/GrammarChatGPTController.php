<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Repositories\UnitRepository;
use OpenAI;
use App\Http\Requests\PostGrammarChatGPTRequest;

class GrammarChatGPTController extends Controller
{
    public function __construct(UnitRepository $unitRepository)
    {
        $this->unit = $unitRepository;
    }

    public function index(Request $questionNumber,$slug)
    {
        $unit = $this->unit->getUnitBySlug($slug);
        $currentQuestionKey = "current_question_{$slug}";

        if (Session::has('is_test_complete')) {
            Session::forget([$currentQuestionKey, 'is_test_complete']);

            return redirect()->route('grammar.index', ['slug' => $slug]);
        }

        $questionNumber = $questionNumber->input('questionNumber') + 1;

        $content = $this->generateGrammarQuestion($slug);
        Session::put($currentQuestionKey, $content);
        $question = Session::get($currentQuestionKey, '');

        return view('grammar_chatgpt.index', compact('unit', 'question', 'questionNumber'));
    }

    public function post(PostGrammarChatGPTRequest $request,$slug)
    {
        $userAnswer = $request->input('answer');
        $correctAnswer = $request->input('correct_answer');
        $question = $request->input('question');
        $questionNumber = $request->input('questionNumber');

        if ($questionNumber >= config('grammarChatGPT.max_questions')){
            Session::put('is_test_complete', true);
            $questionNumber = 1;
        }

        $apiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($apiKey);
        $messageContent = sprintf(config('grammarChatGPT.explanation_prompt'), $question, $correctAnswer, $userAnswer);
        
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'あなたは日本人の小学生向けに英語の文法を解説するAIです。小学生にも分かるように、簡単な言葉で説明してください。'],
                ['role' => 'user', 'content' => $messageContent],
            ],
            'max_tokens' => 300,
            'temperature' => 0.2,
        ]);

        $explanation = $response['choices'][0]['message']['content'];
        $unit = $this->unit->getUnitBySlug($slug);
        
        return view('grammar_chatgpt.index', compact('unit', 'question', 'questionNumber', 'explanation'));
    }

    private function generateGrammarQuestion($slug)
    {
        $apiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($apiKey);
        $messageContent = sprintf(config('grammarChatGPT.question_prompt'), $slug);
                
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'あなたは日本人の小学生向けに英語の文法問題を生成するAIです。シンプルでわかりやすい問題を作ってください。'],
                ['role' => 'user', 'content' => $messageContent],
            ],
            'max_tokens' => 300,
            'temperature' => 0.2,
        ]);

        return $response['choices'][0]['message']['content'];
    }
}