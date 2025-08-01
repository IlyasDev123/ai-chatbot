<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function map(Request $request)
    {
        $prompt = $request->input('prompt');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => env('GEMINI_API_KEY'),
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', [
            'contents' => [[
                'parts' => [[
                    'text' => "Suggest 5 travel locations in '{$prompt}' with the following JSON format:
                    [
                        {\"name\": \"Place Name\", \"description\": \"Short details\", \"lat\": 0.0, \"lng\": 0.0}
                    ]"
                ]]
            ]]
        ]);

        $text = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Extract JSON from AI response using regex
        preg_match('/\[(.*?)\]/s', $text, $matches);

        $places = json_decode($matches[0] ?? '[]', true);

        return response()->json($places);
    }
}
