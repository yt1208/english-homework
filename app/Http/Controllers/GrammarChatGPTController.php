<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use OpenAI;

class GrammarChatGPTController extends Controller
{
    const MAX_QUESTIONS = 5;

    public function index($slug)
    {
        $unit = Unit::where('slug', $slug)->firstOrFail();
        
        if (!Session::has('current_question')) {
            $apiKey = getenv('OPENAI_API_KEY');
            $client = OpenAI::client($apiKey);
            $messageContent = "ユーザーは「{$slug}」について学習しています。次の{$slug}に関する問題を出してください。";
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'あなたは文法テストを作成するAIです。'],
                    ['role' => 'user', 'content' => $messageContent],
                ],
                'max_tokens' => 300,
            ]);
    
            $content = $response['choices'][0]['message']['content'];
            Session::put('current_question', $content);
            Session::put('question_number', 1);
            Session::put('conversation', []);
        }
        
        $question = Session::get('current_question', '');
        $questionNumber = Session::get('question_number', 1);
        $conversation = Session::get('conversation', []);

        return view('grammar_chatgpt.index', compact('unit', 'question', 'questionNumber', 'conversation'));
    }

    public function post(Request $request, $userId)
    {
        $userAnswer = $request->input('answer');
        $correctAnswer = $request->input('correct_answer');
        $question = $request->input('question');
        $slug = $request->input('slug');
        $conversation = Session::get('conversation', []);
        $questionNumber = Session::get('question_number', 1);
        $conversation[] = "Q{$questionNumber}: {$question}";
        $conversation[] = "User Answer: {$userAnswer}";

    if ($userAnswer === $correctAnswer) {
        
        if ($questionNumber >= self::MAX_QUESTIONS) {
            Session::put('is_test_complete', true);
            Session::forget('current_question');
            return redirect()->route('units.index')->with('success', 'テストが終了しました。お疲れさまでした！');
        }

        $apiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($apiKey);
        $messageContent = "ユーザーは「{$slug}」について学習しています。次の{$slug}に関する問題を出してください。";
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'あなたは文法テストを作成するAIです。'],
                ['role' => 'user', 'content' => $messageContent], 
            ],
            'max_tokens' => 300,
        ]);

        $content = $response['choices'][0]['message']['content'];
        $conversation[] = "Next Question: {$content}";
        Session::put('conversation', $conversation);

          return response()->json([
            'correct' => true,
            'next_question' => $content, 
        ]);
    } else {
        $apiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($apiKey);
        $messageContent = "以下の質問に関する解説を生成してください。\n質問: {$question}\n正解: {$correctAnswer}\nユーザーの回答: {$userAnswer}";
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'あなたは文法解説を提供するAIです。'],
                ['role' => 'user', 'content' => $messageContent],
            ],
            'max_tokens' => 300,
        ]);

        $explanation = $response['choices'][0]['message']['content'];
        $conversation[] = "Explanation: {$explanation}";
        Session::put('conversation', $conversation);

        return response()->json([
            'correct' => false,
            'explanation' => $explanation,
            'next_question_button' => true, 
        ]);
    }
}
}