<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with(['user', 'student']);

        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('performed_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('performed_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('performed_at', 'desc')->paginate(20);
        $actions = ActivityLog::distinct()->pluck('action')->filter();
        $users = User::whereIn('id', ActivityLog::distinct()->pluck('user_id'))->get();

        return view('admin.activity-logs.index', compact('logs', 'actions', 'users'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('admin.activity-logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()->route('admin.activity-logs.index')->with('success', 'Activity log deleted successfully.');
    }

    public function clearOldLogs()
    {
        // clear log older than 1 days
        $cutoffDate = now()->subDays(1);
        ActivityLog::where('performed_at', '<', $cutoffDate)->delete();

        return back()->with('success', 'Old activity logs cleared successfully.');
    }
}
