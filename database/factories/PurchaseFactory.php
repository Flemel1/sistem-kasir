<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'purchase_item_name' => fake()->word(),
            'purchase_amount' => fake()->numberBetween(1, 100),
            'purchase_money' => fake()->numberBetween(10000, 500000),
        ];
    }
}
