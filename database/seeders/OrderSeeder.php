<?php

namespace Database\Seeders;

use App\Enums\StatusOrder;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            ['customer_name' => 'Budi Santoso',   'total_payment' => 45000,  'cash_money' => 50000,  'change_money' => 5000,   'status_order' => StatusOrder::CLOSED,  'created_at' => now()->subDays(6)->subHours(2)],
            ['customer_name' => 'Siti Rahmawati', 'total_payment' => 62000,  'cash_money' => 65000,  'change_money' => 3000,   'status_order' => StatusOrder::CLOSED,  'created_at' => now()->subDays(5)->subHours(5)],
            ['customer_name' => 'Ahmad Fauzi',    'total_payment' => 28000,  'cash_money' => 30000,  'change_money' => 2000,   'status_order' => StatusOrder::CLOSED,  'created_at' => now()->subDays(4)->subHours(3)],
            ['customer_name' => 'Dewi Lestari',   'total_payment' => 82000,  'cash_money' => 100000, 'change_money' => 18000,  'status_order' => StatusOrder::CLOSED,  'created_at' => now()->subDays(3)->subHours(6)],
            ['customer_name' => 'Rudi Hartono',   'total_payment' => 37000,  'cash_money' => 37000,  'change_money' => 0,      'status_order' => StatusOrder::CLOSED,  'created_at' => now()->subDays(2)->subHours(4)],
            ['customer_name' => 'Maya Anggraini', 'total_payment' => 54000,  'cash_money' => 55000,  'change_money' => 1000,   'status_order' => StatusOrder::CLOSED,  'created_at' => now()->subDays(1)->subHours(1)],
            ['customer_name' => 'Doni Prasetyo',  'total_payment' => 75000,  'cash_money' => 80000,  'change_money' => 5000,   'status_order' => StatusOrder::CLOSED,  'created_at' => now()->subHours(8)],
            ['customer_name' => 'Rina Marlina',   'total_payment' => 33000,  'cash_money' => 35000,  'change_money' => 2000,   'status_order' => StatusOrder::CLOSED,  'created_at' => now()->subHours(5)],
        ];

        foreach ($orders as $data) {
            Order::create($data);
        }
    }
}
