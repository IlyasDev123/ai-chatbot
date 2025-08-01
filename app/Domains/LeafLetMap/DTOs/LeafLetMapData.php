<?php

namespace App\Domains\LeafLetMap\DTOs;

class LeafLetMapData
{
    public function __construct(
        public readonly string $prompt
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['prompt']
        );
    }
}