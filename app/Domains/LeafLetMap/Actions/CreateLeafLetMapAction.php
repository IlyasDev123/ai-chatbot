<?php

namespace App\Domains\LeafLetMap\Actions;

use Illuminate\Support\Facades\Http;
use App\Domains\LeafLetMap\Models\LeafLetMap;
use App\Domains\LeafLetMap\DTOs\LeafLetMapData;

class CreateLeafLetMapAction
{
    public function execute(LeafLetMapData $data)
    {
        $prompt = $data->prompt;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => env('GEMINI_API_KEY'),
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', [
            'contents' => [[
                'parts' => [[
                    'text' => <<<PROMPT
    You are a travel assistant. Suggest 5 beautiful travel destinations in "{$prompt}" and return only a clean JSON array.

    Each destination must include:
    - name (string)
    - lat (latitude as float)
    - lng (longitude as float)
    - description (description 300 words as string)
    - category (e.g., lake, fort, viewpoint, valley)
    - distance_km (float, approx. distance from the region center)

    Return in this **strict JSON format**:

    [
        {
            "name": "Place Name",
            "lat": 35.1234,
            "lng": 74.5678,
            "description": "A short sentence about this place.",
            "category": "valley",
            "distance_km": 12.5
        },
        ...
    ]
    PROMPT
                ]]
            ]]
        ]);

        $text = $response->json('candidates.0.content.parts.0.text') ?? '';

        // Extract JSON array from response
        preg_match('/\[\s*\{.*?\}\s*\]/s', $text, $matches);

        $places = json_decode($matches[0] ?? '[]', true);

        // Optional: validate structure
        $places = array_filter($places, function ($place) {
            return isset($place['name'], $place['lat'], $place['lng']);
        });

        return array_values($places);
    }
}
