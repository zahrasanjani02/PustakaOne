<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Zahra Sanjani',
            'email' => 'admin@library.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
        ]);

        // Member 1
        User::create([
            'name' => 'Bae Kajol',
            'email' => 'user@library.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '089541726492',
            'address' => 'Jl. Muzahid No. 123',
        ]);

        // Member 2 (optional)
        User::create([
            'name' => 'Rafa Afra',
            'email' => 'rafa@library.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '081234567891',
            'address' => 'Jl. Member No. 2',
        ]);
    }
}