<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employee_name' => fake()->name(),
            'shift' => [
                fake()->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']) . ' 08:00-16:00',
                fake()->randomElement(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']) . ' 16:00-00:00',
            ],
        ];
    }
}
