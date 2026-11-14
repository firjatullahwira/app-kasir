<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kasir.test'],
            ['name' => 'Admin Toko', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'kasir@kasir.test'],
            ['name' => 'Kasir Satu', 'password' => Hash::make('password'), 'role' => 'kasir']
        );
    }
}
