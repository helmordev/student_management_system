<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{
     protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showStudentRegister()
    {
        return view('auth.student_register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            if (!$user->is_active) {
                return back()->withErrors(['email' => 'Your account has been deactivated.']);
            }

            Auth::login($user, $request->remember);

            $this->activityLogService->logActivity(
                'login',
                'User logged in to the system',
                $request,
                $user->isStudent() ? $user->student_id : null
            );

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                return redirect()->intended(route('student.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    public function studentRegister(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'full_name.required' => 'Full name is required.',
            'full_name.min' => 'Full name must be at least 3 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email already exists.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $studentService = app(\App\Services\StudentService::class);
        $studentId = $studentService->generateStudentId();

        $student = User::create([
            'student_id' => $studentId,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        $this->activityLogService->logActivity(
            'registration',
            'Student registered through public registration',
            $request,
            $studentId
        );

        Auth::login($student);

        return redirect()->route('student.dashboard')
            ->with('success', 'Registration successful! Welcome to Student Management System.');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $this->activityLogService->logActivity(
                'logout',
                'User logged out from the system',
                $request,
                $user->isStudent() ? $user->student_id : $user->id
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
