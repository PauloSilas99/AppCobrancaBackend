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
            'client_id' => fake()->numberBetween(1, 50),
            'name' => fake()->words(3, true),
            'quantity' => fake()->numberBetween(1, 30),
            'price' => fake()->randomFloat(2, 5, 120),
        ];
    }
}
