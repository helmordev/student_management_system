@extends('layouts.app')

@section('title', 'Student Grades')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Grades</h1>
                <p class="text-gray-600">View your academic performance</p>
            </div>
            <a href="{{ route('student.grades.download') }}"
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i> Download Report
            </a>
        </div>
    </div>

    <!-- Overall GPA -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $student->gpa }}</div>
                <div class="text-sm text-gray-500">Current GPA</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600">
                    {{ $student->grades->count() }}
                </div>
                <div class="text-sm text-gray-500">Total Subjects</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600">
                    {{ $student->grades->sum('units') }}
                </div>
                <div class="text-sm text-gray-500">Total Units</div>
            </div>
        </div>
    </div>

    <!-- Grades by Semester -->
    @foreach ($grades as $academicYear => $semesters)
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Academic Year: {{ $academicYear }}
                </h3>
            </div>

            @foreach ($semesters as $semester => $semesterGrades)
                <div class="border-b border-gray-200 last:border-0">
                    <div class="px-4 py-4 bg-gray-50">
                        <h4 class="text-md font-medium text-gray-900">Semester: {{ $semester }}</h4>
                    </div>
                    <div class="px-4 py-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subject</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Code</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Units</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Grade</th>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Remarks</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($semesterGrades as $grade)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $grade->subject }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $grade->subject_code }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $grade->units }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if ($grade->grade >= 90) bg-green-100 text-green-800
                                    @elseif($grade->grade >= 80) bg-blue-100 text-blue-800
                                    @elseif($grade->grade >= 70) bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ $grade->grade }} ({{ $grade->letter_grade }})
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $grade->remarks ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- Semester Summary -->
                                    <tr class="bg-gray-50 font-semibold">
                                        <td colspan="2" class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Semester Summary
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $semesterGrades->sum('units') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @php
                                                $semesterUnits = $semesterGrades->sum('units');
                                                $semesterWeighted = $semesterGrades->sum(function ($g) {
                                                    return $g->grade * $g->units;
                                                });
                                                $semesterGPA =
                                                    $semesterUnits > 0
                                                        ? round($semesterWeighted / $semesterUnits, 2)
                                                        : 0;
                                            @endphp
                                            {{ $semesterGPA }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            -
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    @if ($grades->count() === 0)
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-12 text-center">
                <i class="fas fa-graduation-cap text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Grades Available</h3>
                <p class="text-gray-500">Your grades will appear here once they are posted by your instructors.</p>
            </div>
        </div>
    @endif

    <!-- Legend -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h4 class="text-sm font-medium text-gray-900 mb-3">Grade Legend</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                    90-100
                </span>
                <span class="text-sm text-gray-600">Excellent (A)</span>
            </div>
            <div class="flex items-center">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                    80-89
                </span>
                <span class="text-sm text-gray-600">Good (B)</span>
            </div>
            <div class="flex items-center">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mr-2">
                    70-79
                </span>
                <span class="text-sm text-gray-600">Satisfactory (C)</span>
            </div>
            <div class="flex items-center">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                    Below 70
                </span>
                <span class="text-sm text-gray-600">Needs Improvement (D/F)</span>
            </div>
        </div>
    </div>
@endsection
