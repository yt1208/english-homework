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


}
