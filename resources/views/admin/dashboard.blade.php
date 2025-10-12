@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600">Welcome to the administration panel</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Students -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Students</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>

        <!-- Active Students -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-check text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Active Students</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $activeStudents }}</p>
                </div>
            </div>
        </div>

        <!-- Courses -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-book text-2xl text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Courses</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $courseDistribution->count() }}</p>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-server text-2xl text-yellow-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">System Status</h3>
                    <p class="text-lg font-semibold text-green-600">Operational</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <i class="fas fa-history mr-2 text-blue-500"></i>
                    Recent Activity
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach ($recentActivity as $activity)
                            <li>
                                <div class="relative pb-8">
                                    @if (!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                            aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span
                                                class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-history text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    {{ $activity->description }}
                                                    @if ($activity->user)
                                                        <span class="font-medium text-gray-900">
                                                            by {{ $activity->user->full_name }}
                                                        </span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $activity->created_at }}">
                                                    {{ $activity->performed_at->diffForHumans() }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.activity-logs.index') }}"
                        class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                        View all activity logs
                    </a>
                </div>
            </div>
        </div>

        <!-- Course Distribution -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-green-500"></i>
                    Course Distribution
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="space-y-4">
                    @foreach ($courseDistribution as $course)
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $course->course ?? 'Not Assigned' }}</span>
                                <span class="text-sm text-gray-500">{{ $course->total }} students</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                    style="width: {{ ($course->total / $totalStudents) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.students.create') }}"
                    class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-user-plus text-green-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Add Student</h4>
                        <p class="text-sm text-gray-500">Create new student account</p>
                    </div>
                </a>

                <a href="{{ route('admin.students.index') }}"
                    class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-list text-blue-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Manage Students</h4>
                        <p class="text-sm text-gray-500">View all students</p>
                    </div>
                </a>

                <a href="{{ route('admin.grades.index') }}"
                    class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-graduation-cap text-purple-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Manage Grades</h4>
                        <p class="text-sm text-gray-500">Add or edit grades</p>
                    </div>
                </a>

                <a href="{{ route('admin.announcements.index') }}"
                    class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-bullhorn text-yellow-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Post Announcement</h4>
                        <p class="text-sm text-gray-500">Create new announcement</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
