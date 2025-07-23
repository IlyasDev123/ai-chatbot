<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a company
        $company = \App\Models\Company::create([
            'name' => 'Hybridmediaworks',
            'slug' => 'hybridmediaworks',
            'logo' => '',
        ]);

        $events = [];
        for ($i = 1; $i <= 20; $i++) {
            $date = Carbon::now()->addDays(rand(1, 365))->setTime(rand(8, 20), rand(0, 59), 0);
            $events[] = [
                'title' => 'Event ' . $i,
                'description' => 'Description for event ' . $i,
                'date' => $date->toDateTimeString(),
                'location' => 'Venue ' . $i . ', City ' . rand(1, 10),
                'status' => ['upcoming', 'ongoing', 'completed', 'cancelled'][array_rand(['upcoming', 'ongoing', 'completed'])],
                'company_id' => $company->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        \App\Models\Event::insert($events);
    }
}
