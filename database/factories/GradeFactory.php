<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    public function definition()
    {
        $subjects = [
            ['subject' => 'Mathematics', 'code' => 'MATH101'],
            ['subject' => 'English Composition', 'code' => 'ENG101'],
            ['subject' => 'Computer Programming', 'code' => 'CS101'],
            ['subject' => 'Physics', 'code' => 'PHY101'],
            ['subject' => 'Chemistry', 'code' => 'CHEM101'],
            ['subject' => 'Biology', 'code' => 'BIO101'],
            ['subject' => 'History', 'code' => 'HIST101'],
            ['subject' => 'Psychology', 'code' => 'PSY101'],
            ['subject' => 'Economics', 'code' => 'ECON101'],
            ['subject' => 'Business Management', 'code' => 'BUS101'],
            ['subject' => 'Database Systems', 'code' => 'CS201'],
            ['subject' => 'Web Development', 'code' => 'CS202'],
            ['subject' => 'Data Structures', 'code' => 'CS301'],
            ['subject' => 'Algorithms', 'code' => 'CS302'],
            ['subject' => 'Software Engineering', 'code' => 'CS401'],
        ];

        $subject = $this->faker->randomElement($subjects);

        $academicYears = ['2022', '2023', '2024'];
        $semesters = ['1st Semester', '2nd Semester', 'Summer'];

        $grade = $this->faker->randomFloat(2, 65, 100);
        $letterGrade = $this->getLetterGrade($grade);

        $remarks = [
            'Excellent work!',
            'Good performance',
            'Satisfactory',
            'Needs improvement',
            'Outstanding achievement',
            'Consistent performance',
            'Shows great potential',
            null,
            null,
            null,
        ];

        return [
            'student_id' => User::where('role', 'student')->inRandomOrder()->first()->id,
            'subject' => $subject['subject'],
            'subject_code' => $subject['code'],
            'grade' => $grade,
            'units' => $this->faker->numberBetween(3, 5),
            'academic_year' => $this->faker->randomElement($academicYears),
            'semester' => $this->faker->randomElement($semesters),
            'remarks' => $this->faker->randomElement($remarks),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    private function getLetterGrade($grade)
    {
        if ($grade >= 90) {
            return 'A';
        } elseif ($grade >= 80) {
            return 'B';
        } elseif ($grade >= 70) {
            return 'C';
        } elseif ($grade >= 60) {
            return 'D';
        } else {
            return 'F';
        }
    }

    public function excellent()
    {
        return $this->state(function (array $attributes) {
            return [
                'grade' => $this->faker->randomFloat(2, 90, 100),
            ];
        });
    }

    public function good()
    {
        return $this->state(function (array $attributes) {
            return [
                'grade' => $this->faker->randomFloat(2, 80, 89.99),
            ];
        });
    }

    public function average()
    {
        return $this->state(function (array $attributes) {
            return [
                'grade' => $this->faker->randomFloat(2, 70, 79.99),
            ];
        });
    }

    public function poor()
    {
        return $this->state(function (array $attributes) {
            return [
                'grade' => $this->faker->randomFloat(2, 60, 69.99),
            ];
        });
    }
}
