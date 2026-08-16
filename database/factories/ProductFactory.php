<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_name' => fake()->unique()->words(2, true),
            'product_description' => fake()->sentence(),
            'product_price' => fake()->numberBetween(5000, 50000),
            'product_takeaway_price' => fake()->numberBetween(5000, 55000),
            'category_id' => ProductCategory::factory(),
        ];
    }
}
