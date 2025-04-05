<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Barangay;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create([
        //     'password' => Hash::make("Password123!@#")
        // ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'Password123!@#'
        ]);

    }
}
