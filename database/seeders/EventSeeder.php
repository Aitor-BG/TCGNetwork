<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                "name" => "One Piece 09 Local",
                "start_date" => "2025-03-08 17:00",
                "end_date" => "2025-03-08 20:30",
            ],
            [
                "name" => "Lorcana Local",
                "start_date" => "2025-03-09 17:00",
                "end_date" => "2025-03-09 20:30",
            ],
            [
                "name" => "Commander Budget",
                "start_date" => "2025-03-10 17:00",
                "end_date" => "2025-03-10 20:30",
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
