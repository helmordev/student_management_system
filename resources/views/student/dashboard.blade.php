@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Student Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ Auth::user()->full_name }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Student Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-id-card text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Student ID</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->student_id }}</p>
                </div>
            </div>
        </div>

        <!-- Academic Year Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-calendar-alt text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Academic Year</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->academic_year }}</p>
                </div>
            </div>
        </div>

        <!-- Course Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-book text-2xl text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Course</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->course ?? 'Not assigned' }}</p>
                </div>
            </div>
        </div>

        <!-- GPA Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-chart-line text-2xl text-yellow-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Current GPA</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $student->gpa }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Announcements -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <i class="fas fa-bullhorn mr-2 text-blue-500"></i>
                    Recent Announcements
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if ($recentAnnouncements->count() > 0)
                    <div class="space-y-4">
                        @foreach ($recentAnnouncements as $announcement)
                            <div
                                class="border-l-4 border-blue-500 pl-4 py-2 hover:bg-gray-50 rounded transition-colors duration-200">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-semibold text-gray-900">{{ $announcement->title }}</h4>
                                    @if ($announcement->priority === 'high')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-circle mr-1"></i> High
                                        </span>
                                    @elseif($announcement->priority === 'medium')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Medium
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Low
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 150) }}</p>
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-xs text-gray-500">
                                        By: {{ $announcement->author->full_name }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $announcement->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('student.announcements') }}"
                            class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            View all announcements
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-bullhorn text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No announcements yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Grades -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                    <i class="fas fa-graduation-cap mr-2 text-green-500"></i>
                    Recent Grades
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if ($recentGrades->count() > 0)
                    <div class="space-y-3">
                        @foreach ($recentGrades as $grade)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $grade->subject }}</h4>
                                    <p class="text-sm text-gray-500">{{ $grade->subject_code }} •
                                        {{ $grade->academic_year }} - {{ $grade->semester }}</p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if ($grade->grade >= 90) bg-green-100 text-green-800
                                @elseif($grade->grade >= 80) bg-blue-100 text-blue-800
                                @elseif($grade->grade >= 70) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                        {{ $grade->grade }} ({{ $grade->letter_grade }})
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('student.grades') }}"
                            class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            View all grades
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-graduation-cap text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No grades available yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('student.profile') }}"
                    class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-user-edit text-blue-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Update Profile</h4>
                        <p class="text-sm text-gray-500">Edit your personal information</p>
                    </div>
                </a>

                <a href="{{ route('student.grades') }}"
                    class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-file-download text-green-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">Download Grades</h4>
                        <p class="text-sm text-gray-500">Get your grades report</p>
                    </div>
                </a>

                <a href="{{ route('student.announcements') }}"
                    class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-bell text-purple-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">View Announcements</h4>
                        <p class="text-sm text-gray-500">Check latest updates</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
