<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'user_id' => 2,
                'nombre' => 'Case EB02 - One Piece',
                'descripcion' => 'Caja contenedora de 12 Booster Boxes',
                'precio' => 1200,
                'cantidad' => 12,
                'estado' => 'revision',
                'imagen' => 'public/images/op11.png'
            ],
            /*
            [
                'user_id' => 1,
                'nombre' => 'STARTER DECK -GREEN/YELLOW Yamato- [ST-28]',
                'descripcion' => 'DECKS - Release Date: June 6, 2025',
                'precio' => 11.99,
                'cantidad' => 60,
                'estado' => 'revision'
            ],
            [
                'user_id' => 1,
                'nombre' => 'STARTER DECK -BLACK Marshall.D.Teach- [ST-27]',
                'descripcion' => 'DECKS - Release Date: June 6, 2025',
                'precio' => 11.99,
                'cantidad' => 60,
                'estado' => 'revision'
            ],
            [
                'user_id' => 1,
                'nombre' => 'STARTER DECK -PURPLE/BLACK Monkey.D.Luffy- [ST-26]',
                'descripcion' => 'DECKS - Release Date: June 6, 2025',
                'precio' => 11.99,
                'cantidad' => 60,
                'estado' => 'revision'
            ],
            [
                'user_id' => 1,
                'nombre' => 'STARTER DECK -BLUE Buggy- [ST-25]',
                'descripcion' => 'DECKS - Release Date: June 6, 2025',
                'precio' => 11.99,
                'cantidad' => 60,
                'estado' => 'revision'
            ],
            [
                'user_id' => 1,
                'nombre' => 'STARTER DECK -GREEN Jewelry Bonney- [ST-24]',
                'descripcion' => 'DECKS - Release Date: June 6, 2025',
                'precio' => 11.99,
                'cantidad' => 60,
                'estado' => 'revision'
            ],
            [
                'user_id' => 1,
                'nombre' => 'STARTER DECK -RED Shanks- [ST-23]',
                'descripcion' => 'DECKS - Release Date: June 6, 2025',
                'precio' => 11.99,
                'cantidad' => 60,
                'estado' => 'revision'
            ],
            [
                'user_id' => 1,
                'nombre' => 'Case EB02 - One Piece',
                'descripcion' => 'Caja contenedora de 12 Booster Boxes',
                'precio' => 1200,
                'cantidad' => 12,
                'estado' => 'revision'
            ]*/
        ]);
    }
}
