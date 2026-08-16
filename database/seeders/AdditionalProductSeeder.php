<?php

namespace Database\Seeders;

use App\Models\AdditionalProduct;
use Illuminate\Database\Seeder;

class AdditionalProductSeeder extends Seeder
{
    public function run(): void
    {
        AdditionalProduct::create([
            'group_name' => 'Ekstra Shot',
            'items' => [
                ['item_name' => 'Single Shot',  'item_price' => 3000],
                ['item_name' => 'Double Shot',  'item_price' => 5000],
                ['item_name' => 'Triple Shot',  'item_price' => 7000],
            ],
            'is_multiple' => false,
            'is_optional' => true,
        ]);

        AdditionalProduct::create([
            'group_name' => 'Susu',
            'items' => [
                ['item_name' => 'Susu Segar',  'item_price' => 0],
                ['item_name' => 'Susu Almond', 'item_price' => 5000],
                ['item_name' => 'Susu Oat',    'item_price' => 6000],
            ],
            'is_multiple' => false,
            'is_optional' => true,
        ]);

        AdditionalProduct::create([
            'group_name' => 'Topping',
            'items' => [
                ['item_name' => 'Caramel',   'item_price' => 4000],
                ['item_name' => 'Vanilla',   'item_price' => 4000],
                ['item_name' => 'Hazelnut',  'item_price' => 4000],
                ['item_name' => 'Cokelat',   'item_price' => 5000],
            ],
            'is_multiple' => true,
            'is_optional' => true,
        ]);

        AdditionalProduct::create([
            'group_name' => 'Ukuran',
            'items' => [
                ['item_name' => 'Regular',  'item_price' => 0],
                ['item_name' => 'Large',    'item_price' => 5000],
                ['item_name' => 'Extra Large', 'item_price' => 8000],
            ],
            'is_multiple' => false,
            'is_optional' => false,
        ]);
    }
}
