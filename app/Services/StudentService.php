<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

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
