<?php

namespace App\Services;

use App\Models\User;
use App\Models\Grade;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfReportService
{
    public function generateStudentListReport($filters = [])
    {
        $students = User::students()->with('grades');

        if (!empty($filters['course'])) {
            $students->where('course', $filters['course']);
        }

        if (!empty($filters['year_level'])) {
            $students->where('year_level', $filters['year_level']);
        }

        if (!empty($filters['is_active'])) {
            $students->where('is_active', $filters['is_active']);
        }

        $students = $students->get();
        $courses = User::students()->distinct()->pluck('course')->filter();

        $pdf = Pdf::loadView('admin.reports.student-list-pdf', compact('students', 'filters'));
        return $pdf->download('student-list-' . date('Y-m-d') . '.pdf');
    }

    public function generateStudentGradesReport($studentId)
    {
        $student = User::where('student_id', $studentId)->firstOrFail();
        $grades = $student->grades()->orderBy('academic_year', 'desc')
            ->orderBy('semester', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.reports.student-grades', compact('student', 'grades'));
        return $pdf->download('grades-' . $student->student_id . '.pdf');
    }

    public function generateStudentTranscript($studentId)
    {
        $student = User::where('student_id', $studentId)->firstOrFail();
        $grades = $student->grades()
            ->orderBy('academic_year')
            ->orderBy('semester')
            ->get()
            ->groupBy(['academic_year', 'semester']);

        $pdf = Pdf::loadView('admin.reports.student-transcript', compact('student', 'grades'));
        return $pdf->download('transcript-' . $student->student_id . '.pdf');
    }

    public function generateGradeSummaryReport($filters = [])
    {
        $grades = Grade::with('student');

        if (!empty($filters['academic_year'])) {
            $grades->where('academic_year', $filters['academic_year']);
        }

        if (!empty($filters['semester'])) {
            $grades->where('semester', $filters['semester']);
        }

        if (!empty($filters['course'])) {
            $grades->whereHas('student', function ($query) use ($filters) {
                $query->where('course', $filters['course']);
            });
        }

        if (!empty($filters['subject'])) {
            $grades->where('subject', 'like', "%{$filters['subject']}%");
        }

        $grades = $grades->get()->groupBy('subject');

        $pdf = Pdf::loadView('admin.reports.grade-summary', compact('grades', 'filters'));
        return $pdf->download('grade-summary-' . date('Y-m-d') . '.pdf');
    }
}
