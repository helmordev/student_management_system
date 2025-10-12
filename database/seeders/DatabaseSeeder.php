<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'role' => 'admin',
            'full_name' => 'System Administrator',
            'email' => 'admin@school.edu',
            'password' => Hash::make('admin123'),
            'password_changed' => true,
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@school.edu');
        $this->command->info('Password: admin123');
    }
}
