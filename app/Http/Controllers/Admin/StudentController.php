<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        $query = User::students()->with('grades');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->has('course') && $request->course) {
            $query->where('course', $request->course);
        }

        if ($request->has('year_level') && $request->year_level) {
            $query->where('year_level', $request->year_level);
        }

        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active');
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(10);
        $courses = User::students()->distinct()->pluck('course')->filter();
        $yearLevels = User::students()->distinct()->pluck('year_level')->filter();

        return view('admin.students.index', compact('students', 'courses', 'yearLevels'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'full_name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email already exists.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'course.required' => 'Course is required.',
            'year_level.required' => 'Year level is required.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
            'address.max' => 'Address cannot exceed 500 characters.',
        ]);

        $temporaryPassword = Str::random(8);

        $student =  User::create([
            'role' => 'student',
            'student_id' => $this->generateStudentId(),
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => bcrypt($temporaryPassword),
            'course' => $data['course'],
            'year_level' => $data['year_level'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        $this->activityLogService->logActivity(
            'create_student',
            "Created student: {$student->full_name} ({$student->student_id})",
            $request
        );

        return redirect()->route('admin.students.index')
            ->with('success', "Student created successfully. Temporary password: {$temporaryPassword}")
            ->with('temporary_password', $temporaryPassword);
    }

    public function edit(User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }

        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'full_name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email already exists.',
            'course.required' => 'Course is required.',
            'year_level.required' => 'Year level is required.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
            'address.max' => 'Address cannot exceed 500 characters.',
        ]);


        $student->update($request->only(['full_name', 'email', 'course', 'year_level', 'phone', 'address', 'is_active']));

        $this->activityLogService->logActivity(
            'update_student',
            "Updated student: {$student->full_name} ({$student->student_id})",
            $request
        );

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }

        $this->activityLogService->logActivity(
            'delete_student',
            "Deleted student: {$student->full_name} ({$student->student_id})"
        );

        $student->delete();

        return back()->with('success', 'Student deleted successfully.');
    }

    public function resetPassword(User $student)
    {
        if (!$student->isStudent()) {
            abort(404);
        }

        $temporaryPassword = Str::random(8);

        $student->update([
            'password' => bcrypt($temporaryPassword),
            'password_changed' => false,
        ]);

        $this->activityLogService->logActivity(
            "reset_password",
            "Reset Password for student: {$student->full_name}",
            request()
        );

        return back()->with('success', "Password reset successfully. Temporary password: {$temporaryPassword}")
            ->with('temporary_password', $temporaryPassword);
    }
}
