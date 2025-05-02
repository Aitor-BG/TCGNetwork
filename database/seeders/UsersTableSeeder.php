<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([

            [
                'name' => 'tienda',
                'username' => 'tienda',
                'email' => 'tienda@tienda.com',
                'password' => Hash::make('111'),
                'role' => 'tienda',
            ],
            [
                'name' => 'usuario',
                'username' => 'usuario',
                'email' => 'usuario@usuario.com',
                'password' => Hash::make('111'),
                'role' => 'usuario',
            ],
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
            ],
        ]);

    }
}