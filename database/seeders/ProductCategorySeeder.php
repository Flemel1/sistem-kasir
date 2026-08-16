<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Kopi', 'Non-Kopi', 'Makanan Ringan', 'Minuman Segar'];

        foreach ($categories as $name) {
            ProductCategory::create(['category_name' => $name]);
        }
    }
}
