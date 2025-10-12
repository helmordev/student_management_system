<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $announcements = Announcement::with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'publish_at' => 'nullable|date',
        ], [
            'title.required' => 'The title field is required.',
            'content.required' => 'The content field is required.',
            'priority.required' => 'The priority field is required.',
            'publish_at.date' => 'The publish_at field must be a valid date.',
        ]);

        Announcement::create($request->all());

        $this->activityLogService->logActivity(
            'create_announcement',
            "Created announcement: {$request->title}"
        );

        return back()->with('success', 'Announcement created successfully.');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'publish_at' => 'nullable|date',
        ], [
            'title.required' => 'The title field is required.',
            'content.required' => 'The content field is required.',
            'priority.required' => 'The priority field is required.',
            'publish_at.date' => 'The publish_at field must be a valid date.',
        ]);

        $announcement->update($request->all());

        $this->activityLogService->logActivity(
            'update_announcement',
            "Updated announcement: {$request->title}"
        );

        return back()->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title;
        $announcement->delete();

        $this->activityLogService->logActivity(
            'delete_announcement',
            "Deleted announcement: {$title}"
        );

        return back()->with('success', 'Announcement deleted successfully.');
    }

    public function toggleStatus(Announcement $announcement)
    {
        $announcement->update([
            'is_active' => !$announcement->is_active
        ]);

        $status = $announcement->is_active ? 'activated' : 'deactivated';

        $this->activityLogService->logActivity(
            'toggle_announcement',
            "{$status} announcement: {$announcement->title}"
        );

        return back()->with('success', "Announcement {$status} successfully.");
    }
}
