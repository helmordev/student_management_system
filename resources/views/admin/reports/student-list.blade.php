@extends('layouts.app')

@section('title', 'Student Reports')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Student Reports</h1>
        <p class="text-gray-600">Generate and download student reports</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Report Filters -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Generate Student List Report</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form method="POST" action="{{ route('admin.reports.students.generate') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Course Filter -->
                            <div>
                                <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                <select name="course" id="course"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Courses</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course }}">{{ $course }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Year Level Filter -->
                            <div>
                                <label for="year_level" class="block text-sm font-medium text-gray-700 mb-1">Year
                                    Level</label>
                                <select name="year_level" id="year_level"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Levels</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Status</option>
                                    <option value="active">Active Only</option>
                                    <option value="inactive">Inactive Only</option>
                                </select>
                            </div>

                            <!-- Report Format -->
                            <div>
                                <label for="format" class="block text-sm font-medium text-gray-700 mb-1">Report
                                    Format</label>
                                <select name="format" id="format"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="pdf" selected>PDF Document</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">
                                        Report Information
                                    </h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>The report will include: Student ID, Full Name, Email, Course, Year Level,
                                            and Status</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i> Generate Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Reports -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Quick Reports</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-4">
                        <a href="{{ route('admin.grades.summary.download') }}"
                            class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-chart-bar text-blue-500 text-xl mr-3"></i>
                                <div>
                                    <h4 class="font-medium text-gray-900">Grade Summary</h4>
                                    <p class="text-sm text-gray-500">Overall grade statistics</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>

                        <a href="{{ route('admin.reports.grades') }}"
                            class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <i class="fas fa-graduation-cap text-green-500 text-xl mr-3"></i>
                                <div>
                                    <h4 class="font-medium text-gray-900">Grade Reports</h4>
                                    <p class="text-sm text-gray-500">Detailed grade analysis</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Report Statistics -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Statistics</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total Students</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ \App\Models\User::students()->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Active Students</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ \App\Models\User::students()->active()->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Courses</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ \App\Models\User::students()->distinct()->count('course') }}
                            </span>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection
