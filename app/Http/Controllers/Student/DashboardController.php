<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        $student = Auth::user();
        $recentAnnouncements = Announcement::active()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentGrades = $student->grades()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('student.dashboard', compact('student', 'recentAnnouncements', 'recentGrades'));
    }
}
