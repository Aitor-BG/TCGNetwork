<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Crea un usuario relacionado automáticamente
            'nombre' => $this->faker->words(2, true), // Nombre de producto tipo: "Zapato deportivo"
            'descripcion' => $this->faker->sentence(), // Descripción aleatoria
            'precio' => $this->faker->randomFloat(2, 1, 500), // Precio entre 1.00 y 500.00
            'cantidad' => $this->faker->numberBetween(1, 100), // Cantidad entre 1 y 100
            'estado' => 'revision'
        ];
    }
}
