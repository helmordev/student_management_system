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
        ]);

        $this->call([
            StudentSeeder::class,
            GradeSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
