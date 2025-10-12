@extends('layouts.app')

@section('title', 'Manage Grades')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Grade Management</h1>
                <p class="text-gray-600">Manage student grades and academic records</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.reports.grades') }}"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-chart-bar mr-2"></i> Reports
                </a>
                <button type="button" onclick="document.getElementById('addGradeForm').classList.toggle('hidden')"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Add Grade
                </button>
            </div>
        </div>
    </div>

    <!-- Add Grade Form -->
    <div id="addGradeForm" class="hidden bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Grade</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('admin.grades.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Student -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student *</label>
                        <select name="student_id" id="student_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('student_id') border-red-500 @enderror">
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->full_name }} ({{ $student->student_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('subject') border-red-500 @enderror">
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject Code -->
                    <div>
                        <label for="subject_code" class="block text-sm font-medium text-gray-700 mb-1">Subject Code
                            *</label>
                        <input type="text" name="subject_code" id="subject_code" value="{{ old('subject_code') }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('subject_code') border-red-500 @enderror">
                        @error('subject_code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grade -->
                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Grade *</label>
                        <input type="number" name="grade" id="grade" value="{{ old('grade') }}" min="0"
                            max="100" step="0.01" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('grade') border-red-500 @enderror">
                        @error('grade')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Units -->
                    <div>
                        <label for="units" class="block text-sm font-medium text-gray-700 mb-1">Units *</label>
                        <input type="number" name="units" id="units" value="{{ old('units', 3) }}" min="1"
                            max="10" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('units') border-red-500 @enderror">
                        @error('units')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Academic Year -->
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic Year
                            *</label>
                        <input type="text" name="academic_year" id="academic_year"
                            value="{{ old('academic_year', date('Y')) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('academic_year') border-red-500 @enderror">
                        @error('academic_year')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester *</label>
                        <select name="semester" id="semester" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('semester') border-red-500 @enderror">
                            <option value="1st Semester" {{ old('semester') == '1st Semester' ? 'selected' : '' }}>1st
                                Semester</option>
                            <option value="2nd Semester" {{ old('semester') == '2nd Semester' ? 'selected' : '' }}>2nd
                                Semester</option>
                            <option value="Summer" {{ old('semester') == 'Summer' ? 'selected' : '' }}>Summer</option>
                        </select>
                        @error('semester')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="md:col-span-2">
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('remarks') border-red-500 @enderror">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('addGradeForm').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Add Grade
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('admin.grades.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Student Filter -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                        <select name="student_id" id="student_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Students</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Academic Year Filter -->
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic
                            Year</label>
                        <select name="academic_year" id="academic_year"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Years</option>
                            @foreach ($academicYears as $year)
                                <option value="{{ $year }}"
                                    {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semester Filter -->
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <select name="semester" id="semester"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Semesters</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester }}"
                                    {{ request('semester') == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Filter -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" name="subject" id="subject" value="{{ request('subject') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Subject name">
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-3">
                    <a href="{{ route('admin.grades.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Reset
                    </a>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Grades Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Grades ({{ $grades->total() }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Academic
                            Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($grades as $grade)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $grade->student->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $grade->student->student_id }}</div>
                                <div class="text-xs text-gray-400">{{ $grade->student->course }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $grade->subject }}</div>
                                <div class="text-sm text-gray-500">{{ $grade->subject_code }}</div>
                                <div class="text-xs text-gray-400">{{ $grade->units }} units</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $grade->academic_year }}</div>
                                <div class="text-sm text-gray-500">{{ $grade->semester }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if ($grade->grade >= 90) bg-green-100 text-green-800
                            @elseif($grade->grade >= 80) bg-blue-100 text-blue-800
                            @elseif($grade->grade >= 70) bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ $grade->grade }} ({{ $grade->letter_grade }})
                                </span>
                                @if ($grade->remarks)
                                    <div class="text-xs text-gray-500 mt-1">{{ $grade->remarks }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button type="button" onclick="editGrade({{ $grade->toJson() }})"
                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                        title="Edit Grade">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.grades.delete', $grade) }}"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                            title="Delete Grade"
                                            onclick="return confirm('Are you sure you want to delete this grade?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="fas fa-graduation-cap text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Grades Found</h3>
                                <p class="text-gray-500">No grades match your search criteria.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($grades->hasPages())
            <div class="px-4 py-4 border-t border-gray-200">
                {{ $grades->links() }}
            </div>
        @endif
    </div>

    <!-- Edit Grade Modal -->
    <div id="editGradeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Grade</h3>
                </div>
                <form id="editGradeForm" method="POST" class="px-4 py-5">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                            <p class="text-sm text-gray-900" id="editStudentName"></p>
                        </div>
                        <div>
                            <label for="edit_subject" class="block text-sm font-medium text-gray-700 mb-1">Subject
                                *</label>
                            <input type="text" name="subject" id="edit_subject" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="edit_subject_code" class="block text-sm font-medium text-gray-700 mb-1">Subject
                                Code *</label>
                            <input type="text" name="subject_code" id="edit_subject_code" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="edit_grade" class="block text-sm font-medium text-gray-700 mb-1">Grade *</label>
                            <input type="number" name="grade" id="edit_grade" min="0" max="100"
                                step="0.01" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="edit_units" class="block text-sm font-medium text-gray-700 mb-1">Units *</label>
                            <input type="number" name="units" id="edit_units" min="1" max="10" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="edit_academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic
                                Year *</label>
                            <input type="text" name="academic_year" id="edit_academic_year" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="edit_semester" class="block text-sm font-medium text-gray-700 mb-1">Semester
                                *</label>
                            <select name="semester" id="edit_semester" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="edit_remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                            <textarea name="remarks" id="edit_remarks" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Update Grade
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    function editGrade(grade) {
        // Populate the modal fields
        document.getElementById('editStudentName').innerText = grade.student.full_name;
        document.getElementById('edit_subject').value = grade.subject;
        document.getElementById('edit_subject_code').value = grade.subject_code;
        document.getElementById('edit_grade').value = grade.grade;
        document.getElementById('edit_units').value = grade.units;
        document.getElementById('edit_academic_year').value = grade.academic_year;
        document.getElementById('edit_semester').value = grade.semester;
        document.getElementById('edit_remarks').value = grade.remarks;

        const form = document.getElementById('editGradeForm');
        form.action = `/admin/grades/${grade.id}`;

        document.getElementById('editGradeModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editGradeModal').classList.add('hidden');
    }
</script>

