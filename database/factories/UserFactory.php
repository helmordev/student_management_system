<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        $currentYear = date('Y');
        $studentId = $currentYear . '-' . str_pad($this->faker->unique()->numberBetween(1, 999999), 6, '0', STR_PAD_LEFT);

        $courses = [
            'Computer Science',
            'Information Technology',
            'Business Administration',
            'Engineering',
            'Nursing',
            'Education',
            'Psychology',
            'Accounting',
            'Marketing',
            'Hospitality Management'
        ];

        $yearLevels = ['1st Year', '2nd Year', '3rd Year', '4th Year'];

        return [
            'role' => 'student',
            'student_id' => $studentId,
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'course' => $this->faker->randomElement($courses),
            'year_level' => $this->faker->randomElement($yearLevels),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'is_active' => $this->faker->boolean(90), // 90% active
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
                'student_id' => null,
                'course' => null,
                'year_level' => null,
                'is_active' => true,
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
