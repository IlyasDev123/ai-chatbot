<?php

namespace App\Domains\Chatbot\DTOs;

class ChatbotData
{
    public function __construct(
        public readonly string $message
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['message']
        );
    }
}