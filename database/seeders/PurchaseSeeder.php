<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $purchases = [
            ['purchase_item_name' => 'Biji Kopi Arabica 1kg',  'purchase_amount' => 5,  'purchase_money' => 450000],
            ['purchase_item_name' => 'Biji Kopi Robusta 1kg', 'purchase_amount' => 3,  'purchase_money' => 240000],
            ['purchase_item_name' => 'Susu UHT 1L',           'purchase_amount' => 20, 'purchase_money' => 500000],
            ['purchase_item_name' => 'Sirup Caramel',          'purchase_amount' => 10, 'purchase_money' => 250000],
            ['purchase_item_name' => 'Tepung Terigu 1kg',     'purchase_amount' => 10, 'purchase_money' => 150000],
            ['purchase_item_name' => 'Gula Pasir 1kg',        'purchase_amount' => 15, 'purchase_money' => 225000],
        ];

        foreach ($purchases as $data) {
            Purchase::create($data);
        }
    }
}
