<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // updateOrCreate: aman dijalankan berulang (tidak error duplikat email)
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administrator', 'password' => 'password123', 'role' => 'admin'],
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'User Biasa', 'password' => 'password123', 'role' => 'user'],
        );
    }
}
