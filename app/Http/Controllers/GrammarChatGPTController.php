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
        $messageContent = "以下の質問に関する解説を小学生でも理解出来るように生成してください。質問の正しい解答も明記する。\n質問: {$question}\n正解: {$correctAnswer}\nユーザーの回答: {$userAnswer}";
        $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'あなたは文法解説を提供するAIです。'],
                    ['role' => 'user', 'content' => $messageContent],
                ],
                'max_tokens' => 300,
            ]);

        $explanation = $response['choices'][0]['message']['content'];
        $unit = Unit::where('slug', $slug)->firstOrFail();
            return view('grammar_chatgpt.index', compact('unit', 'question', 'questionNumber', 'explanation'));
    }

    private function generateGrammarQuestion($slug)
    {
        $apiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($apiKey);
        $messageContent = "ユーザーは日本人で、英検５級に向けて「{$slug}」について学習しています。「{$slug}」に関する文法問題を小学生レベルで1つだけ作成してください。問題文は穴埋め形式にする。";
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'あなたは文法テストを作成するAIです。'],
                ['role' => 'user', 'content' => $messageContent],
            ],
            'max_tokens' => 300,
        ]);

        return $response['choices'][0]['message']['content'];
    }
}