<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OperationCostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cost_name' => fake()->word(),
            'cost_description' => fake()->sentence(),
            'cost_nominal' => fake()->numberBetween(50000, 5000000),
        ];
    }
}
