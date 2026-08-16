<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        Shift::create([
            'employee_name' => 'Ahmad Fauzi',
            'shift' => [
                'Senin 08:00-16:00',
                'Selasa 08:00-16:00',
                'Rabu 08:00-16:00',
                'Kamis Off',
                'Jumat 08:00-16:00',
                'Sabtu 08:00-16:00',
                'Minggu Off',
            ],
        ]);

        Shift::create([
            'employee_name' => 'Dewi Lestari',
            'shift' => [
                'Senin 16:00-00:00',
                'Selasa 16:00-00:00',
                'Rabu Off',
                'Kamis 16:00-00:00',
                'Jumat 16:00-00:00',
                'Sabtu 16:00-00:00',
                'Minggu 16:00-00:00',
            ],
        ]);

        Shift::create([
            'employee_name' => 'Rudi Hartono',
            'shift' => [
                'Senin Off',
                'Selasa Off',
                'Rabu 16:00-00:00',
                'Kamis 08:00-16:00',
                'Jumat Off',
                'Sabtu 10:00-18:00',
                'Minggu 10:00-18:00',
            ],
        ]);
    }
}
