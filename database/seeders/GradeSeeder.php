<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run()
    {
        $students = User::where('role', 'student')->get();

        foreach ($students as $student) {
            // Each student gets between 8 and 20 grades
            $numberOfGrades = rand(8, 20);

            Grade::factory()
                ->count($numberOfGrades)
                ->create([
                    'student_id' => $student->id,
                ]);
        }

        // Create some excellent grades
        Grade::factory()
            ->excellent()
            ->count(50)
            ->create();

        // Create some poor grades for variety
        Grade::factory()
            ->poor()
            ->count(30)
            ->create();

        $totalGrades = Grade::count();
        $this->command->info('Grades created successfully!');
        $this->command->info('Total grades: ' . $totalGrades);

        // Display grade distribution
        $this->displayGradeDistribution();
    }

    private function displayGradeDistribution()
    {
        $distributions = [
            'A (90-100)' => Grade::where('grade', '>=', 90)->count(),
            'B (80-89)' => Grade::whereBetween('grade', [80, 89.99])->count(),
            'C (70-79)' => Grade::whereBetween('grade', [70, 79.99])->count(),
            'D (60-69)' => Grade::whereBetween('grade', [60, 69.99])->count(),
            'F (Below 60)' => Grade::where('grade', '<', 60)->count(),
        ];

        $this->command->info('Grade Distribution:');
        foreach ($distributions as $range => $count) {
            $percentage = ($count / Grade::count()) * 100;
            $this->command->info("  {$range}: {$count} grades (" . number_format($percentage, 1) . "%)");
        }
    }
}
