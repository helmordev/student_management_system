@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Activity Logs</h1>
        <p class="text-gray-600">Monitor system activities and user actions</p>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Action Filter -->
                    <div>
                        <label for="action" class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                        <select name="action" id="action"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Actions</option>
                            @foreach ($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ $action }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">User</label>
                        <select name="user_id" id="user_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->full_name }} ({{ $user->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }}
                        results
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.activity-logs.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            Reset
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Logs -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                System Activity Logs
            </h3>
            <form method="POST" action="{{ route('admin.activity-logs.clear-old') }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 border border-yellow-300 rounded-md shadow-sm text-sm font-medium text-yellow-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200"
                    onclick="return confirm('Are you sure you want to clear logs older than one day?')">
                    <i class="fas fa-broom mr-2"></i> Clear Old Logs
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action &
                            Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student
                            ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP
                            Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if (in_array($log->action, ['login', 'registration', 'create_student'])) bg-green-100 text-green-800
                                @elseif(in_array($log->action, ['update', 'edit', 'change_password'])) bg-blue-100 text-blue-800
                                @elseif(in_array($log->action, ['delete', 'logout'])) bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                        {{ $log->action }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-900 mt-1">{{ $log->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($log->user)
                                    <div class="text-sm text-gray-900">{{ $log->user->full_name }}</div>
                                    <div class="text-sm text-gray-500 capitalize">{{ $log->user->role }}</div>
                                @else
                                    <span class="text-sm text-gray-500">System</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->student_id ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $log->performed_at->format('M d, Y') }}</div>
                                <div>{{ $log->performed_at->format('g:i A') }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $log->performed_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.activity-logs.show', $log) }}"
                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                        title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.activity-logs.delete', $log) }}"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                            title="Delete Log"
                                            onclick="return confirm('Are you sure you want to delete this activity log?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Activity Logs</h3>
                                <p class="text-gray-500">No activity logs match your search criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($logs->hasPages())
            <div class="px-4 py-4 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Logs -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-history text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Logs</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $logs->total() }}</p>
                </div>
            </div>
        </div>

        <!-- Unique Users -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Active Users</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $users->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Most Common Action -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-chart-bar text-2xl text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Common Action</h3>
                    <p class="text-lg font-semibold text-gray-900 capitalize">
                        {{ $actions->first() ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
