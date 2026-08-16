<?php

namespace Database\Seeders;

use App\Models\OperationCost;
use Illuminate\Database\Seeder;

class OperationCostSeeder extends Seeder
{
    public function run(): void
    {
        $costs = [
            ['cost_name' => 'Listrik Bulanan',    'cost_description' => 'Biaya listrik untuk outlet Kopi Raya',           'cost_nominal' => 1500000],
            ['cost_name' => 'Sewa Tempat',         'cost_description' => 'Sewa ruko untuk outlet bulan ini',               'cost_nominal' => 5000000],
            ['cost_name' => 'Air PDAM',            'cost_description' => 'Tagihan air bersih bulanan',                     'cost_nominal' => 350000],
            ['cost_name' => 'Gaji Karyawan',       'cost_description' => 'Gaji 3 orang karyawan shift',                    'cost_nominal' => 9000000],
            ['cost_name' => 'Internet & Wi-Fi',    'cost_description' => 'Biaya langganan internet bulanan',               'cost_nominal' => 500000],
            ['cost_name' => 'Perawatan Mesin Kopi','cost_description' => 'Servis rutin mesin espresso dan grinder',        'cost_nominal' => 750000],
        ];

        foreach ($costs as $data) {
            OperationCost::create($data);
        }
    }
}
