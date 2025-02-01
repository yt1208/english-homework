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
        $messageContent = "以下の質問に関する解説を日本人の小学生でも理解出来るように生成してください。
        解説は簡単な言葉で説明し、難しい単語は出ないようにする。
        また、ユーザーの回答が正しいかどうかをAIで判定し、結果を明記してください。（正解の場合は「〇」、間違いの場合は「✖」）
        
        問題: {$question}
        
        【正解の番号】{$correctAnswer}
        【ユーザーの選んだ番号】{$userAnswer}
        
        【出力フォーマット】
        1. 正誤: 「〇」または「✖」
        2. 解説: 日本人の小学生にも分かるように簡単な言葉で説明
        ※「###」などの記号は使用せず、シンプルに出力すること
        ";
        
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
        $messageContent = "「{$slug}」に関する文法問題を1問生成してください。問題は日本人の小学生でも解けるような簡単な問題にして、4択形式の穴埋め問題にする。
        以下のフォーマットで問題を出力してください。
        問題文の中の1つの単語を『____』として空欄にし、4つの選択肢(①, ②, ③, ④）を提示してください。
        正解の選択肢は必ず1つだけにし、他の3つは間違いの選択肢を作成してください。
        問題はできるだけ簡単な単語や文法ルールを使ってください。
        出力形式は以下の通りにしてください：
        
        【問題】次の空欄に入る適切な単語を、①〜④の中から1つ選び、番号で回答してください。

        <問題文（例: I ___ a student.）>

        ① <選択肢1>
        ② <選択肢2>
        ③ <選択肢3>
        ④ <選択肢4>";
                
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'あなたは日本人の小学生向けに英語の文法問題を生成するAIです。シンプルでわかりやすい問題を作ってください。'],
                ['role' => 'user', 'content' => $messageContent],
            ],
            'max_tokens' => 300,
            'temperature' => 0.3,
        ]);

        return $response['choices'][0]['message']['content'];
    }
}