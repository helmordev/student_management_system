<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function announcements()
    {
        $announcements = Announcement::active()
            ->with('author')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.announcements', compact('announcements'));
    }
}
