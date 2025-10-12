<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $activityLogService;
    protected $studentService;

    public function __construct(ActivityLogService $activityLogService, StudentService $studentService)
    {
        $this->activityLogService = $activityLogService;
        $this->studentService = $studentService;
    }

    public function dashboard()
    {
        $stats = $this->studentService->getStudentStatistics();
        $recentActivity = $this->activityLogService->getRecentActivity(10);

        return view('admin.dashboard', array_merge($stats, compact('recentActivity')));
    }
}
