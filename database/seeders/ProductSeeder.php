<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['product_name' => 'Espresso',     'product_description' => 'Kopi hitam pekat khas Italia, dibuat dengan tekanan tinggi.', 'product_price' => 18000, 'product_takeaway_price' => 20000, 'category_id' => 1],
            ['product_name' => 'Americano',     'product_description' => 'Espresso dengan tambahan air panas, rasa lebih ringan.', 'product_price' => 20000, 'product_takeaway_price' => 22000, 'category_id' => 1],
            ['product_name' => 'Cappuccino',    'product_description' => 'Espresso dengan susu steamed dan busa susu yang lembut.', 'product_price' => 25000, 'product_takeaway_price' => 27000, 'category_id' => 1],
            ['product_name' => 'Cafe Latte',    'product_description' => 'Espresso dengan susu steamed yang creamy.', 'product_price' => 25000, 'product_takeaway_price' => 27000, 'category_id' => 1],
            ['product_name' => 'Mocha',         'product_description' => 'Perpaduan espresso, susu, dan cokelat yang nikmat.', 'product_price' => 28000, 'product_takeaway_price' => 30000, 'category_id' => 1],
            ['product_name' => 'Matcha Latte',  'product_description' => 'Minuman matcha asli Jepang dengan susu segar.', 'product_price' => 27000, 'product_takeaway_price' => 29000, 'category_id' => 2],
            ['product_name' => 'Chocolate',     'product_description' => 'Minuman cokelat panas dengan topping whipped cream.', 'product_price' => 25000, 'product_takeaway_price' => 27000, 'category_id' => 2],
            ['product_name' => 'Red Velvet',    'product_description' => 'Minuman red velvet dengan cream cheese yang lezat.', 'product_price' => 28000, 'product_takeaway_price' => 30000, 'category_id' => 2],
            ['product_name' => 'Croissant',     'product_description' => 'Roti lapis khas Prancis, renyah di luar, lembut di dalam.', 'product_price' => 15000, 'product_takeaway_price' => 15000, 'category_id' => 3],
            ['product_name' => 'Pisang Goreng', 'product_description' => 'Pisang goreng crispy dengan taburan gula kayu manis.', 'product_price' => 12000, 'product_takeaway_price' => 12000, 'category_id' => 3],
            ['product_name' => 'Lemon Tea',     'product_description' => 'Teh segar dengan perasan lemon asli dan es batu.', 'product_price' => 15000, 'product_takeaway_price' => 17000, 'category_id' => 4],
            ['product_name' => 'Es Jeruk',      'product_description' => 'Jus jeruk segar peras dengan es batu.', 'product_price' => 15000, 'product_takeaway_price' => 17000, 'category_id' => 4],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
