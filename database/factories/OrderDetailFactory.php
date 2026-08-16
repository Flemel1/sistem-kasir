<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'order_id' => Order::factory(),
            'amount' => fake()->numberBetween(1, 5),
        ];
    }
}
