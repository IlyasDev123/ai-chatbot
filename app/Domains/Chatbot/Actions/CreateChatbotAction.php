<?php

namespace App\Domains\Chatbot\Actions;

use Illuminate\Support\Facades\Http;
use App\Domains\Chatbot\Models\Chatbot;
use App\Domains\Chatbot\DTOs\ChatbotData;

class CreateChatbotAction
{
    public function execute(ChatbotData $data): string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => env('GEMINI_API_KEY'),
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $data->message]
                    ]
                ]
            ]
        ]);

        return $response->json('candidates.0.content.parts.0.text') ?? 'No response';
    }
}