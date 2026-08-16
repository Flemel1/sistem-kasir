<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'group_name' => fake()->unique()->word(),
            'items' => [
                ['item_name' => fake()->word(), 'item_price' => fake()->numberBetween(2000, 10000)],
                ['item_name' => fake()->word(), 'item_price' => fake()->numberBetween(2000, 10000)],
            ],
            'is_multiple' => fake()->boolean(),
            'is_optional' => fake()->boolean(),
        ];
    }
}
