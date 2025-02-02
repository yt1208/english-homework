<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use OpenAI;

class GrammarChatGPTController extends Controller
{

    public function index(Request $questionNumber,$slug)
    {
        $unit = Unit::where('slug', $slug)->firstOrFail();
        $currentQuestionKey = "current_question_{$slug}";
        $conversation = '';
        $conversationKey = "conversation_{$slug}";

        if (Session::has('is_test_complete')) {
            Session::forget([$currentQuestionKey, $conversationKey, 'is_test_complete']);
        }

        $questionNumber = $questionNumber->input('questionNumber') + 1;

        $content = $this->generateGrammarQuestion($slug);
        Session::put($currentQuestionKey, $content);
        $question = Session::get($currentQuestionKey, '');

        return view('grammar_chatgpt.index', compact('unit', 'question', 'questionNumber', 'conversation'));
    }

    public function post(Request $request,$slug)
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
        $unit = Unit::where('slug', $slug)->firstOrFail();
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