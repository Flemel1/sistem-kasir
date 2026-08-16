<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Kopi Raya',
            'username' => 'admin',
            'email' => 'admin@kopiraya.com',
            'password' => bcrypt('admin'),
        ]);

        User::create([
            'name' => 'Kasir 1',
            'username' => 'kasir1',
            'email' => 'kasir1@kopiraya.com',
            'password' => bcrypt('kasir123'),
        ]);

        User::create([
            'name' => 'Kasir 2',
            'username' => 'kasir2',
            'email' => 'kasir2@kopiraya.com',
            'password' => bcrypt('kasir123'),
        ]);
    }
}
