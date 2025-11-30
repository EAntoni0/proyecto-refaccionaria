<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3), //genear un nombre de 3 palabras
            'description' => fake()->paragraph(), //generar texto largo
            'price' => fake()->randomFloat(2, 100, 5000), //precio entre 100 y 5000 con 2 decimales
            'stock' => fake()->numberBetween(1, 100), //cantidad entre 1 y 100
            'image' => null,

            //qui se asigna en automatico una categoria al producto
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
