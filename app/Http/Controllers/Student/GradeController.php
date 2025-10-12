<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use App\Services\PdfReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    protected $activityLogService;
    protected $pdfReportService;

    public function __construct(ActivityLogService $activityLogService, PdfReportService $pdfReportService)
    {
        $this->activityLogService = $activityLogService;
        $this->pdfReportService = $pdfReportService;
    }

    public function grades()
    {
        $student = Auth::user();
        $grades = $student->grades()
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester', 'desc')
            ->get()
            ->groupBy(['academic_year', 'semester']);

        return view('student.grades', compact('student', 'grades'));
    }

    public function downloadGrades()
    {
        $student = Auth::user();

        $this->activityLogService->logActivity(
            'download_grades',
            'Student downloaded grades report',
            request(),
            $student->student_id
        );

        return $this->pdfReportService->generateStudentGradesReport($student->student_id);
    }
}
