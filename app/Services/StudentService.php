<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class StudentService
{
    public function generateStudentId()
    {
        $currentYear = date('Y');
        $lastStudent = User::students()
            ->where('student_id', 'like', $currentYear . '-%')
            ->orderBy('student_id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastStudent && preg_match('/-(\d+)$/', $lastStudent->student_id, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }

        return $currentYear . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    public function createStudent(array $data)
    {
        $temporaryPassword = Str::random(8);

        $student = User::create([
            'role' => 'student',
            'student_id' => $this->generateStudentId(),
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($temporaryPassword),
            'course' => $data['course'],
            'year_level' => $data['year_level'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        return ['student' => $student, 'temporary_password' => $temporaryPassword];
    }

    public function getStudentStatistics()
    {
        $totalStudents = User::students()->count();
        $activeStudents = User::students()->active()->count();

        $courseDistribution = User::students()
            ->select('course', \DB::raw('count(*) as total'))
            ->groupBy('course')
            ->get();

        $yearLevelDistribution = User::students()
            ->select('year_level', \DB::raw('count(*) as total'))
            ->groupBy('year_level')
            ->get();

        return compact('totalStudents', 'activeStudents', 'courseDistribution', 'yearLevelDistribution');
    }
}
