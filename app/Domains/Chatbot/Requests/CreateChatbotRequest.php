<?php

namespace App\Domains\Chatbot\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChatbotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string|max:1000',
        ];
    }
}