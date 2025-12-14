<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // For testing, I left a single seeder with one user and one agent to make it simpler. In a real environment, I would prefer separate them or use factories.

        // New User as user role
        User::create([
            'name' => 'Test User',
            'email' => 'user@clearit.com',
            'password' => 'user123',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // New User as agent role
        User::create([
            'name' => 'Test Agent',
            'email' => 'agent@clearit.com',
            'password' => 'agent123',
            'role' => 'agent',
            'email_verified_at' => now(),
        ]);
    }
}
