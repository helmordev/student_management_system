@extends('layouts.app')

@section('title', 'Activity Log Details')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Activity Log Details</h1>
                    <p class="text-gray-600">Detailed information about this system activity</p>
                </div>
                <a href="{{ route('admin.activity-logs.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Logs
                </a>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Activity Information</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Action Type</label>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if (in_array($activityLog->action, ['login', 'registration', 'create_student'])) bg-green-100 text-green-800
                            @elseif(in_array($activityLog->action, ['update', 'edit', 'change_password'])) bg-blue-100 text-blue-800
                            @elseif(in_array($activityLog->action, ['delete', 'logout'])) bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                                {{ $activityLog->action }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">
                                {{ $activityLog->description }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Performed At</label>
                            <p class="text-sm text-gray-900">
                                {{ $activityLog->performed_at->format('F d, Y \a\t g:i A') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                ({{ $activityLog->performed_at->diffForHumans() }})
                            </p>
                        </div>
                    </div>

                    <!-- User Information -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">User Information</label>
                            @if ($activityLog->user)
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm text-gray-900">
                                        <strong>Name:</strong> {{ $activityLog->user->full_name }}
                                    </p>
                                    <p class="text-sm text-gray-900">
                                        <strong>Email:</strong> {{ $activityLog->user->email }}
                                    </p>
                                    <p class="text-sm text-gray-900">
                                        <strong>Role:</strong> <span
                                            class="capitalize">{{ $activityLog->user->role }}</span>
                                    </p>
                                    @if ($activityLog->user->isStudent())
                                        <p class="text-sm text-gray-900">
                                            <strong>Student ID:</strong> {{ $activityLog->user->student_id }}
                                        </p>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-500 bg-gray-50 p-3 rounded-md">
                                    System-generated activity
                                </p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Student ID</label>
                            <p class="text-sm text-gray-900">
                                {{ $activityLog->student_id ?? 'Not applicable' }}
                            </p>
                        </div>
                    </div>

                    <!-- Technical Information -->
                    <div class="md:col-span-2 space-y-4">
                        <div class="border-t border-gray-200 pt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Technical Details</label>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-900">
                                            <strong>IP Address:</strong> {{ $activityLog->ip_address ?? 'Not recorded' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900">
                                            <strong>User Agent:</strong>
                                        </p>
                                        <p class="text-xs text-gray-500 break-words">
                                            {{ $activityLog->user_agent ?? 'Not recorded' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900">
                                            <strong>Log ID:</strong> {{ $activityLog->id }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-900">
                                            <strong>Created:</strong>
                                            {{ $activityLog->created_at->format('M d, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Actions</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Delete this log entry</h4>
                        <p class="text-sm text-gray-500">
                            Permanently delete this activity log entry. This action cannot be undone.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('admin.activity-logs.delete', $activityLog->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
                            onclick="return confirm('Are you sure you want to delete this activity log?')">
                            <i class="fas fa-trash mr-2"></i> Delete Log
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
