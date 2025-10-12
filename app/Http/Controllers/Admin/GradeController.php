<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\PdfReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    protected $activityLogService;
    protected $pdfReportService;

    public function __construct(ActivityLogService $activityLogService, PdfReportService $pdfReportService)
    {
        $this->activityLogService = $activityLogService;
        $this->pdfReportService = $pdfReportService;
    }

    public function index(Request $request)
    {
        $query = Grade::with('student');

        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('academic_year') && $request->academic_year) {
            $query->where('academic_year', $request->academic_year);
        }

        if ($request->has('semester') && $request->semester) {
            $query->where('semester', $request->semester);
        }

        if ($request->has('subject') && $request->subject) {
            $query->where('subject', 'like', "%{$request->subject}%");
        }

        $grades = $query->orderBy('academic_year', 'desc')
            ->orderBy('semester', 'desc')
            ->orderBy('subject')
            ->paginate(15);

        $students = User::students()->active()->get();
        $academicYears = Grade::distinct()->pluck('academic_year')->filter();
        $semesters = Grade::distinct()->pluck('semester')->filter();

        return view('admin.grades.index', compact('grades', 'students', 'academicYears', 'semesters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'subject_code' => 'required|string|max:50',
            'grade' => 'required|numeric|min:0|max:100',
            'units' => 'required|integer|min:1',
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|string|max:20',
            'remarks' => 'nullable|string',
        ], [
            'student_id.required' => 'The student field is required.',
            'subject.required' => 'The subject field is required.',
            'subject_code.required' => 'The subject code field is required.',
            'grade.required' => 'The grade field is required.',
            'units.required' => 'The units field is required.',
            'academic_year.required' => 'The academic year field is required.',
            'semester.required' => 'The semester field is required.',
        ]);

        Grade::create($request->all());
        $student = User::find($request->student_id);

        $this->activityLogService->logActivity(
            'add_grade',
            "Added grade for {$student->full_name} in {$request->subject}",
            $request,
            $student->student_id
        );

        return back()->with('success', 'Grade added successfully.');
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'subject_code' => 'required|string|max:50',
            'grade' => 'required|numeric|min:0|max:100',
            'units' => 'required|integer|min:1',
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|string|max:20',
            'remarks' => 'nullable|string',
        ], [
            'subject.required' => 'The subject field is required.',
            'subject_code.required' => 'The subject code field is required.',
            'grade.required' => 'The grade field is required.',
            'units.required' => 'The units field is required.',
            'academic_year.required' => 'The academic year field is required.',
            'semester.required' => 'The semester field is required.',
        ]);

        $grade->update($request->all());

        $this->activityLogService->logActivity(
            'update_grade',
            "Updated grade for student ID: {$grade->student_id} in {$request->subject}",
            $request,
            $grade->student->student_id
        );

        return back()->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $studentId = $grade->student->student_id;
        $subject = $grade->subject;

        $grade->delete();

        $this->activityLogService->logActivity(
            'delete_grade',
            "Deleted grade for student ID: {$studentId} in {$subject}",
            request(),
            $studentId
        );

        return back()->with('success', 'Grade deleted successfully.');
    }

    public function downloadGradeSummary(Request $request)
    {
        $filters = $request->only(['academic_year', 'semester', 'course', 'subject']);

        $this->activityLogService->logActivity(
            'download_grade_summary',
            'Downloaded grade summary report'
        );

        return $this->pdfReportService->generateGradeSummaryReport($filters);
    }
}
