<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            AdditionalProductSeeder::class,
            ProductsAdditionalProductsSeeder::class,
            OrderSeeder::class,
            OrderDetailSeeder::class,
            ShiftSeeder::class,
            OpenOrderSeeder::class,
            PurchaseSeeder::class,
            OperationCostSeeder::class,
        ]);
    }
}
