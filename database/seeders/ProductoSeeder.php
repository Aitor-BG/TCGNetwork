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
                'user_id'=>1,
                'nombre'=>'Case EB02 - One Piece',
                'descripcion'=>'Caja contenedora de 12 Booster Boxes',
                'precio'=>1200,
                'cantidad'=>12,
                'estado'=>'revision'
            ]
        ]);
    }
}
