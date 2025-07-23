<?php

namespace App\Domains\Chatbot\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Chatbot\DTOs\ChatbotData;
use App\Domains\Chatbot\Actions\CreateChatbotAction;
use App\Domains\Chatbot\Requests\CreateChatbotRequest;

class ChatbotController extends Controller
{
    public function index()
    {
        return Inertia::render('Chatbot/Index');
    }

    public function ask(CreateChatbotRequest $request, CreateChatbotAction $action)
    {
        $dto = ChatbotData::fromArray($request->validated());

        $message = $action->execute($dto);

        return response()->json(['message' => $message]);
    }
}
