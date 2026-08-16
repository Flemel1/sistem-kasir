<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Order 1: Budi — 1 Cappuccino + 1 Pisang Goreng
        OrderDetail::create(['product_id' => 3, 'order_id' => 1, 'amount' => 1]);
        OrderDetail::create(['product_id' => 10, 'order_id' => 1, 'amount' => 1]);

        // Order 2: Siti — 2 Cafe Latte + 1 Croissant
        OrderDetail::create(['product_id' => 4, 'order_id' => 2, 'amount' => 2]);
        OrderDetail::create(['product_id' => 9, 'order_id' => 2, 'amount' => 1]);

        // Order 3: Ahmad — 1 Americano + 1 Lemon Tea
        OrderDetail::create(['product_id' => 2, 'order_id' => 3, 'amount' => 1]);
        OrderDetail::create(['product_id' => 11, 'order_id' => 3, 'amount' => 1]);

        // Order 4: Dewi — 1 Mocha + 1 Matcha Latte + 1 Es Jeruk
        OrderDetail::create(['product_id' => 5, 'order_id' => 4, 'amount' => 1]);
        OrderDetail::create(['product_id' => 6, 'order_id' => 4, 'amount' => 1]);
        OrderDetail::create(['product_id' => 12, 'order_id' => 4, 'amount' => 1]);

        // Order 5: Rudi — 1 Espresso + 1 Pisang Goreng
        OrderDetail::create(['product_id' => 1, 'order_id' => 5, 'amount' => 1]);
        OrderDetail::create(['product_id' => 10, 'order_id' => 5, 'amount' => 2]);

        // Order 6: Maya — 1 Cappuccino + 1 Chocolate
        OrderDetail::create(['product_id' => 3, 'order_id' => 6, 'amount' => 1]);
        OrderDetail::create(['product_id' => 7, 'order_id' => 6, 'amount' => 1]);

        // Order 7: Doni — 1 Mocha + 1 Red Velvet + 1 Croissant
        OrderDetail::create(['product_id' => 5, 'order_id' => 7, 'amount' => 1]);
        OrderDetail::create(['product_id' => 8, 'order_id' => 7, 'amount' => 1]);
        OrderDetail::create(['product_id' => 9, 'order_id' => 7, 'amount' => 1]);

        // Order 8: Rina — 1 Americano
        OrderDetail::create(['product_id' => 2, 'order_id' => 8, 'amount' => 1]);
        OrderDetail::create(['product_id' => 11, 'order_id' => 8, 'amount' => 1]);
    }
}
