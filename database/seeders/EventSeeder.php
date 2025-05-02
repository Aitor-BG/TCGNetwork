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
                "name" => "One Piece 10 Local",
                "date" => "2025-05-06",
                "color" => "rgb(255,0,0)",
                "details" => "Torneo en formato OP10. Aplican bans oficiales de Bandai.",
                "inscritos" => "",
                "participantes" => 16 
            ],
            [
                "name" => "Lorcana Local",
                "date" => "2025-05-05",
                "color" => "rgb(255,0,255)",
                "details" => "Torneo en formato Archazia's Island. Aplican bans oficiales de Ravensburg.",
                "inscritos" => "",
                "participantes" => 16 
            ],
            [
                "name" => "Magic Commander",
                "date" => "2025-05-07",
                "color" => "rgb(204, 171, 99)",
                "details" => "Torneo con mazos budget (100€ máx). Para conocer el precio de tu mazo introducirlo en la app Manabox y regirse por el mínimo. Pasar el precio por artes alternativos no importa.",
                "inscritos" => "",
                "participantes" => 16 
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
