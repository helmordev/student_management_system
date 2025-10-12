@extends('layouts.app')

@section('title', 'Grade Reports')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Grade Reports</h1>
        <p class="text-gray-600">Generate comprehensive grade reports</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Grade Summary Report -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Grade Summary Report</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form method="GET" action="{{ route('admin.grades.summary.download') }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Academic Year -->
                            <div>
                                <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic
                                    Year</label>
                                <select name="academic_year" id="academic_year"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Years</option>
                                    @foreach ($academicYears as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Semester -->
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                                <select name="semester" id="semester"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Semesters</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester }}">{{ $semester }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Course -->
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

                            <!--Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <select name="subject" id="subject"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Subjects</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject }}">{{ $subject }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i> Download Summary
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Quick Transcripts -->
        <div class="space-y-6">
            <!-- Report Statistics -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Statistics</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Total Grades</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ \App\Models\Grade::count() }}
                            </span>
                        </div>
                       <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Subjects</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ \App\Models\Grade::distinct()->count('subject') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Academic Years</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ \App\Models\Grade::distinct()->count('academic_year') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Distribution -->
    <div class="mt-8 bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Grade Entries</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Academic Year</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $recentGrades = \App\Models\Grade::with('student')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @forelse($recentGrades as $grade)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $grade->student->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $grade->student->student_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $grade->subject }}</div>
                                    <div class="text-sm text-gray-500">{{ $grade->subject_code }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if ($grade->grade >= 90) bg-green-100 text-green-800
                                @elseif($grade->grade >= 80) bg-blue-100 text-blue-800
                                @elseif($grade->grade >= 70) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                        {{ $grade->grade }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $grade->academic_year }} - {{ $grade->semester }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $grade->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <i class="fas fa-graduation-cap text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500">No grade entries found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
