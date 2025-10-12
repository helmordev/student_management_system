<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Grade;
use App\Services\ActivityLogService;
use App\Services\PdfReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $activityLogService;
    protected $pdfReportService;

    public function __construct(ActivityLogService $activityLogService, PdfReportService $pdfReportService)
    {
        $this->activityLogService = $activityLogService;
        $this->pdfReportService = $pdfReportService;
    }

    public function studentList(Request $request)
    {
        $courses = User::students()->distinct()->pluck('course')->filter();
        $yearLevels = User::students()->distinct()->pluck('year_level')->filter();

        return view('admin.reports.student-list', compact('courses', 'yearLevels'));
    }

    public function generateStudentList(Request $request)
    {
        $filters = $request->only(['course', 'year_level', 'status']);

        $this->activityLogService->logActivity(
            'generate_student_list',
            'Generated student list report'
        );

        return $this->pdfReportService->generateStudentListReport($filters);
    }

    public function gradeReports()
    {
        $academicYears = Grade::distinct()->pluck('academic_year')->filter();
        $semesters = Grade::distinct()->pluck('semester')->filter();
        $courses = User::students()->distinct()->pluck('course')->filter();
        $subjects = Grade::distinct()->pluck('subject')->filter();

        return view('admin.reports.grade-reports', compact('academicYears', 'semesters', 'courses', 'subjects'));
    }
}
