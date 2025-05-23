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
                'user_id'=>2,
                'nombre'=>'Case EB02 - One Piece',
                'descripcion'=>'Caja contenedora de 12 Booster Boxes',
                'precio'=>1200,
                'cantidad'=>12,
                'estado'=>'revision'
            ],
                    [
            'user_id' => 1,
            'nombre' => 'BOOSTER PACK -CARRYING ON HIS WILL- [OP-13]',
            'descripcion' => 'BOOSTERS - Release Date: November 2025 - MSRP: USD $4.99 per pack',
            'precio' => 4.99,
            'cantidad' => 100,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'PREMIUM BOOSTER -ONE PIECE CARD THE BEST Vol.2- [PRB-02]',
            'descripcion' => 'BOOSTERS - Release Date: October 2025 - MSRP: USD $5.99 per pack',
            'precio' => 5.99,
            'cantidad' => 100,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'STARTER DECK -Ace & Newgate- [ST-22]',
            'descripcion' => 'DECKS - Release Date: September 2025 - MSRP: USD $16.99',
            'precio' => 16.99,
            'cantidad' => 50,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'Official Sleeves 11',
            'descripcion' => 'OTHER - Release Date: August 22, 2025 - MSRP: USD $8.00',
            'precio' => 8.00,
            'cantidad' => 200,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'Official Card Sleeve TCG+ Store Edition vol.4',
            'descripcion' => 'OTHER - Release Date: August 22, 2025 - MSRP: USD $8.00',
            'precio' => 8.00,
            'cantidad' => 200,
                            'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'BOOSTER PACK -LEGACY OF THE MASTER- [OP-12]',
            'descripcion' => 'BOOSTERS - Release Date: August 2025 - MSRP: USD $4.99 per pack',
            'precio' => 4.99,
            'cantidad' => 100,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'Premium Card Collection -Best Selection Vol.4-',
            'descripcion' => 'OTHER - MSRP: USD $25.00',
            'precio' => 25.00,
            'cantidad' => 30,
                            'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'Official Playmat Limited Edition Vol.3',
            'descripcion' => 'OTHER - MSRP: USD $30.00',
            'precio' => 30.00,
            'cantidad' => 25,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'Seven Warlords of the Sea Binder Set',
            'descripcion' => 'OTHER - MSRP: USD $50.00',
            'precio' => 50.00,
            'cantidad' => 20,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'Official Dice and Dice Case Set',
            'descripcion' => 'OTHER - Release Date: August 2025 - MSRP: USD $15.00',
            'precio' => 15.00,
            'cantidad' => 40,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'STARTER DECK -GREEN/YELLOW Yamato- [ST-28]',
            'descripcion' => 'DECKS - Release Date: June 6, 2025 - MSRP: $11.99',
            'precio' => 11.99,
            'cantidad' => 60,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'STARTER DECK -BLACK Marshall.D.Teach- [ST-27]',
            'descripcion' => 'DECKS - Release Date: June 6, 2025 - MSRP: $11.99',
            'precio' => 11.99,
            'cantidad' => 60,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'STARTER DECK -PURPLE/BLACK Monkey.D.Luffy- [ST-26]',
            'descripcion' => 'DECKS - Release Date: June 6, 2025 - MSRP: $11.99',
            'precio' => 11.99,
            'cantidad' => 60,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'STARTER DECK -BLUE Buggy- [ST-25]',
            'descripcion' => 'DECKS - Release Date: June 6, 2025 - MSRP: $11.99',
            'precio' => 11.99,
            'cantidad' => 60,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'STARTER DECK -GREEN Jewelry Bonney- [ST-24]',
            'descripcion' => 'DECKS - Release Date: June 6, 2025 - MSRP: $11.99',
            'precio' => 11.99,
            'cantidad' => 60,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'STARTER DECK -RED Shanks- [ST-23]',
            'descripcion' => 'DECKS - Release Date: June 6, 2025 - MSRP: $11.99',
            'precio' => 11.99,
            'cantidad' => 60,
                'estado'=>'revision'
        ],
        [
            'user_id' => 1,
            'nombre' => 'Case EB02 - One Piece',
            'descripcion' => 'Caja contenedora de 12 Booster Boxes',
            'precio' => 1200,
            'cantidad' => 12,
                'estado'=>'revision'
        ]
        ]);
    }
}
