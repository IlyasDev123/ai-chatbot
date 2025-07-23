<?php

namespace App\Domains\Event\DTOs;

class EventData
{
    public function __construct(
        // public readonly string $title
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            // $data['title']
        );
    }
}