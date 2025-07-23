<?php

namespace App\Domains\Event\Actions;

use App\Domains\Event\DTOs\EventData;
use App\Domains\Event\Models\Event;

class CreateEventAction
{
    public function execute(EventData $data): Event
    {
        return Event::create([
            // 'title' => $data->title,
        ]);
    }
}