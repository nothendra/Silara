<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@lapor.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);

        // Buat RT
        User::create([
            'name' => 'RT 001',
            'email' => 'rt@lapor.com',
            'password' => Hash::make('123'),
            'role' => 'rt',
        ]);

        // Buat Warga (untuk testing)
        User::create([
            'name' => 'Warga Test',
            'email' => 'warga@lapor.com',
            'password' => Hash::make('123'),
            'role' => 'warga',
        ]);
    }
}