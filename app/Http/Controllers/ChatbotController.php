<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use Illuminate\Support\Facades\Session;

class ChatbotController extends Controller
{
    public function ask(AskChatbotRequest $request)
    {
        $apiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($apiKey);
        $userMessage = $request->input('message');
        $conversation = Session::get('conversation', []);
        $conversation[] = ['role' => 'user', 'content' => $userMessage];
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'あなたは日本人の小学生向けに英語の文法を解説するAIです。小学生にも分かるように、簡単な言葉で説明してください。'],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'max_tokens' => 300,
            'temperature' => 0.2,
        ]);

        $botReply = $response['choices'][0]['message']['content'];

        $conversation[] = ['role' => 'assistant', 'content' => $botReply];

        Session::put('conversation', $conversation);

        return response()->json($botReply);
    }
}
