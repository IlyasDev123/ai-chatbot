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
                    'role' => 'user',
                    'parts' => [
                        ['text' => $this->promptText()]
                    ]
                ],
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $data->message]
                    ]
                ]
            ]
        ]);

        return  $this->cleanAIResponse($response['candidates'][0]['content']['parts'][0]['text']) ?? 'No response from Gemini';
    }

    public function promptText(): string
    {
        return <<<EOT
                You are a specialized Travel Information API. Your sole function is to process user queries and return a response formatted exclusively as a complete, valid HTML document.
                Your entire output MUST begin with the `<html>` tag and end with the `</html>` tag. There must be absolutely no text, explanations, or characters before `<html>` or after `</html>`.

                ---
                USER QUERY CONTEXT:
                You will receive a user query about travel. Based on that query, you will generate a helpful, detailed response using your knowledge of:
                - Destination Information: Attractions, history, visiting times, fees.
                - Accommodation Recommendations: Hotels by budget with amenities.
                - Transportation Guidance: Travel routes, rentals, local transport.
                - Itinerary Planning: Day-by-day plans.
                - Cultural Insights: Etiquette and local phrases.
                - Dining Recommendations: Food spots by budget and specialty.

                ---
                IF THE USER QUERY IS NOT RELATED TO TRAVEL:
                Instead of returning HTML, return the following plain response exactly:
                Sorry, I specialize in travel assistance.
                Please ask me about destinations, accommodations, travel tips, transportation, or dining options.

                ---
                OUTPUT FORMAT RULES:
                1.  **HTML Only:** Your entire response must be a single block of valid HTML.
                2.  **Mandatory Structure:** The response MUST start with `<html>` and end with `</html>`.
                3.  **Allowed Tags:** Use semantic HTML: `<h1>`, `<h2>`, `<p>`, `<ul>`, `<li>`, `<strong>`, `<em>`, `<br>`.
                4.  **Forbidden Content:**
                    - DO NOT include any conversational text like "Here is the information you requested..."
                    - DO NOT include any text or characters outside of the `<html>...</html>` block.
                    - DO NOT use Markdown, JSON, or plain text.

                ---
                SORRY_MESSAGE:
                Sorry, I am a travel assistant and can only provide help related to travel, tourism, destinations, hotels, itineraries, transportation, and dining.

                ---
                EXAMPLE OF A GOOD RESPONSE:
                <html>
                <head>
                    <title>Travel Information</title>
                </head>
                <body>
                    <h1>Visiting Skardu, Pakistan</h1>
                    <p><strong>Top Attractions:</strong> Shangrila Resort, Shigar Fort, and Deosai National Park.</p>
                </body>
                </html>

                ---
                Remember: Do NOT include anything before `<html>` or after `</html>`. If the query is not travel-related, return the plain 
                Sorry, I specialize in travel assistance.
                Please ask me about destinations, accommodations, travel tips, transportation, or dining options.
                Thank you for your query. I hope you find the information you need. If you have any further questions, please don't hesitate to ask. Best regards, the travel assistant above.
                EOT;
    }


    public function cleanAIResponse(string $response): string
    {
        return str_replace(['```html', '```php', '```'], '', $response);
    }
}
