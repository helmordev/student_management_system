<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function profile(): View
    {
        $student = Auth::user();
        return view('student.profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $student = Auth::user();

        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'phone' => 'required|string',
            'address' => 'required|string',
        ], [
            'full_name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'Email already exists.',
            'phone.required' => 'Phone number is required.',
            'address.required' => 'Address is required.',
        ]);

        $student->update($request->only(['full_name', 'email', 'phone', 'address']));

        $this->activityLogService->logActivity(
            'profile_update',
            'Student updated profile information',
            $request,
            $student->student_id
        );

        return back()->with('success', 'Profile updated successfully.');
    }

    public function showChangePassword(): View
    {
        return view('student.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'new_password_confirmation' => 'required|string|same:new_password',
        ], [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password_confirmation.required' => 'Confirm password is required.',
            'new_password_confirmation.same' => 'Confirm password does not match.',
        ]);

        $student = Auth::user();

        if (!Hash::check($request->current_password, $student->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $student->update([
            'password' => Hash::make($request->new_password),
            'password_changed' => true,
        ]);

        $this->activityLogService->logActivity(
            'password_change',
            'Student changed password',
            $request,
            $student->student_id
        );

        return redirect()->route('student.dashboard')->with('success', 'Password changed successfully.');
    }
}
