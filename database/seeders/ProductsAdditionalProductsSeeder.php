<?php

namespace Database\Seeders;

use App\Models\ProductsAdditionalProducts;
use Illuminate\Database\Seeder;

class ProductsAdditionalProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Kopi products (IDs 1-5) get Ekstra Shot (ID 1), Susu (ID 2), Topping (ID 3), Ukuran (ID 4)
        for ($productId = 1; $productId <= 5; $productId++) {
            for ($addonId = 1; $addonId <= 4; $addonId++) {
                ProductsAdditionalProducts::create([
                    'product_id' => $productId,
                    'additional_product_id' => $addonId,
                ]);
            }
        }

        // Non-Kopi products (IDs 6-8) get Topping (ID 3) and Ukuran (ID 4)
        for ($productId = 6; $productId <= 8; $productId++) {
            ProductsAdditionalProducts::create([
                'product_id' => $productId,
                'additional_product_id' => 3,
            ]);
            ProductsAdditionalProducts::create([
                'product_id' => $productId,
                'additional_product_id' => 4,
            ]);
        }

        // Minuman Segar (IDs 11-12) get Ukuran (ID 4)
        for ($productId = 11; $productId <= 12; $productId++) {
            ProductsAdditionalProducts::create([
                'product_id' => $productId,
                'additional_product_id' => 4,
            ]);
        }
    }
}
