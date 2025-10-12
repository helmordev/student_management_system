<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        // Create active students
        $activeStudents = User::factory()
            ->count(150)
            ->create();

        // Create some inactive students
        $inactiveStudents = User::factory()
            ->inactive()
            ->count(20)
            ->create();

        $this->command->info('Students created successfully!');
        $this->command->info('Total students: ' . ($activeStudents->count() + $inactiveStudents->count()));
        $this->command->info('Active students: ' . $activeStudents->count());
        $this->command->info('Inactive students: ' . $inactiveStudents->count());
    }
}
