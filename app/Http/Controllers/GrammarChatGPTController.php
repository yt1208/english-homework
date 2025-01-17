<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GrammarChatGPTController extends Controller
{
        /**
     * 文法テストの開始ページ
     *
     * @param string $slug ユニットのスラッグ
     * @return \Illuminate\View\View
     */
    public function index($slug)
    {
        
        $unit = Unit::where('slug', $slug)->firstOrFail();
        $questions = $this->generateQuestions($unit->name);

        return view('grammar_chatgpt.index', compact('unit', 'questions'));
    }

        /**
     * ユーザーの回答をチェックし、結果を返す
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAnswer(Request $request)
    {
        $question = $request->input('question');         
        $userAnswer = $request->input('answer');         
        $correctAnswer = $request->input('correct_answer'); 

        if ($userAnswer === $correctAnswer) {
            return response()->json(['correct' => true]);
        } else {
            $explanation = $this->generateExplanation($question, $correctAnswer);

            return response()->json([
                'correct' => false,
                'explanation' => $explanation,
            ]);
        }
    }

        /**
     * AIを使って文法問題を生成する
     *
     * @param string $topic 学習トピック
     * @return array
     */
    private function generateQuestions($topic)
    {
        $apiKey = env('OPENAI_API_KEY');
        $prompt = "次のトピックについて文法の4択問題を5問生成してください。各問題には4つの選択肢と1つの正しい答えを含め、JSON形式で出力してください。トピック: $topic";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/completions', [
            'model' => 'gpt-3.5-turbo',
            'prompt' => $prompt,
            'max_tokens' => 1000,
        ]);

        if ($response->successful()) {
            return json_decode($response->body(), true)['choices'][0]['text'];
        } else {
            return [];
        }
    }

        /**
     * AIを使って解説を生成する
     *
     * @param string $question 質問文
     * @param string $correctAnswer 正しい答え
     * @return string
     */

     private function generateExplanation($question, $correctAnswer)
     {
         $apiKey = env('OPENAI_API_KEY');
         $prompt = "次の文法問題に対する正しい答えが '$correctAnswer' である理由を説明してください。問題: $question";
 
         $response = Http::withHeaders([
             'Authorization' => 'Bearer ' . $apiKey,
             'Content-Type' => 'application/json',
         ])->post('https://api.openai.com/v1/completions', [
             'model' => 'gpt-3.5-turbo',
             'prompt' => $prompt,
             'max_tokens' => 500,
         ]);
 
         if ($response->successful()) {
             return $response->json()['choices'][0]['text'];
         } else {
             return "解説の生成に失敗しました。";
         }
     }
}
