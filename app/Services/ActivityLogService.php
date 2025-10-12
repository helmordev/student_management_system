<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public function logActivity($action, $description, Request $request = null, $studentId = null)
    {
        $user = Auth::user();

        $logData = [
            'user_id' => $user ? $user->id : null,
            'student_id' => $studentId ?: ($user && $user->isStudent() ? $user->student_id : null),
            'action' => $action,
            'description' => $description,
            'performed_at' => now(),
        ];

        if ($request) {
            $logData['ip_address'] = $request->ip();
            $logData['user_agent'] = $request->userAgent();
        }

        return ActivityLog::create($logData);
    }

    public function getRecentActivity($limit = 10)
    {
        return ActivityLog::with(['user', 'student'])
            ->orderBy('performed_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStudentActivity($studentId, $limit = 20)
    {
        return ActivityLog::where('student_id', $studentId)
            ->orWhere('user_id', function ($query) use ($studentId) {
                $query->select('id')
                    ->from('users')
                    ->where('student_id', $studentId);
            })
            ->with(['user', 'student'])
            ->orderBy('performed_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
