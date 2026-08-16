<?php

namespace Database\Factories;

use App\Enums\StatusOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $total = fake()->numberBetween(10000, 200000);
        $cash = fake()->randomElement([$total, $total + fake()->numberBetween(0, 50000)]);

        return [
            'customer_name' => fake()->name(),
            'total_payment' => $total,
            'cash_money' => $cash,
            'change_money' => $cash - $total,
            'status_order' => fake()->randomElement([StatusOrder::OPENED, StatusOrder::CLOSED]),
        ];
    }
}
