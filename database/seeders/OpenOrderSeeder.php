<?php

namespace Database\Seeders;

use App\Models\OpenOrder;
use Illuminate\Database\Seeder;

class OpenOrderSeeder extends Seeder
{
    public function run(): void
    {
        OpenOrder::create([
            'customer_name' => 'Tamara',
            'ordered_items' => [
                ['product_name' => 'Cappuccino', 'product_id' => 3, 'amount' => 2, 'price' => 25000, 'notes' => 'Extra hot'],
                ['product_name' => 'Croissant',  'product_id' => 9, 'amount' => 1, 'price' => 15000, 'notes' => ''],
            ],
            'grand_total' => 65000,
            'doned_at' => null,
        ]);

        OpenOrder::create([
            'customer_name' => 'Pak RT',
            'ordered_items' => [
                ['product_name' => 'Kopi Americano', 'product_id' => 2, 'amount' => 4, 'price' => 20000, 'notes' => 'Takeaway semua'],
                ['product_name' => 'Pisang Goreng',  'product_id' => 10, 'amount' => 4, 'price' => 12000, 'notes' => ''],
            ],
            'grand_total' => 128000,
            'doned_at' => null,
        ]);
    }
}
