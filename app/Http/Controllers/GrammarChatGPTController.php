<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use OpenAI;

class GrammarChatGPTController extends Controller
{

    public function index($slug)
    {
        $unit = Unit::where('slug', $slug)->firstOrFail();
        $currentQuestionKey = "current_question_{$slug}";
        $conversation = '';
        $i = 0;
        $i = Session::get($i, 1);
        $conversationKey = "conversation_{$slug}";

            $apiKey = getenv('OPENAI_API_KEY');
            $client = OpenAI::client($apiKey);
            $messageContent = "ユーザーは「{$slug}」について学習しています。「{$slug}」に関する文法問題を1つだけ作成してください。問題文のみを出力してください。解答や解説は含めないでください。";
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'あなたは文法テストを作成するAIです。'],
                    ['role' => 'user', 'content' => $messageContent],
                ],
                'max_tokens' => 300,
            ]);

            $content = $response['choices'][0]['message']['content'];
            Session::put($currentQuestionKey, $content);
            Session::put($i, $i+1);

        $question = Session::get($currentQuestionKey, '');
        $questionNumber = Session::get($i, 1);

        return view('grammar_chatgpt.index', compact('unit', 'question', 'questionNumber', 'conversation'));
    }

    public function post(Request $request, $userId)
    {
        $slug = $request->input('slug');
        $currentQuestionKey = "current_question_{$slug}";
        $questionNumberKey = "question_number_{$slug}";
        $conversationKey = "conversation_{$slug}";

        $userAnswer = $request->input('answer');
        $correctAnswer = $request->input('correct_answer');
        $question = $request->input('question');
        $conversation = Session::get($conversationKey, []);
        $questionNumber = Session::get($questionNumberKey, 1);

        $conversation[] = "Q{$questionNumber}: {$question}";
        $conversation[] = "User Answer: {$userAnswer}";

        if ($userAnswer === $correctAnswer) {
            if ($questionNumber >= config('grammarChatGPT.max_questions')){
                Session::put('is_test_complete', true);
                Session::forget($currentQuestionKey);
                return redirect()->route('units.index')->with('success', 'テストが終了しました。お疲れさまでした！');
            }

            $apiKey = getenv('OPENAI_API_KEY');
            $client = OpenAI::client($apiKey);
            $messageContent = "ユーザーは「{$slug}」について学習しています。「{$slug}」に関する文法問題を1つだけ作成してください。問題文のみを出力してください。解答や解説は含めないでください。";
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
            Session::put($conversationKey, $conversation);
            Session::put($currentQuestionKey, $content);
            $questionNumber = Session::get($questionNumberKey, 1);
            Session::put($questionNumberKey, $questionNumber + 1);

            return redirect()->route('grammar.index', ['slug' => $slug]);
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
            Session::put($conversationKey, $conversation);

            return view('grammar_chatgpt.index', [
                'unit' => Unit::where('slug', $slug)->firstOrFail(),
                'question' => $question,
                'questionNumber' => $questionNumber,
                'conversation' => $conversation,
                'explanation' => $explanation,
            ]);
        }
    }
}