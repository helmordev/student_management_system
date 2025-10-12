@extends('layouts.app')

@section('title', 'Manage Students')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Student Management</h1>
            <p class="text-gray-600">Manage all student accounts and information</p>
        </div>
        <a href="{{ route('admin.students.create') }}"
           class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
            <i class="fas fa-user-plus mr-2"></i> Add Student
        </a>
    </div>
</div>

<!-- Filters and Search -->
<div class="bg-white shadow rounded-lg mb-6">
    <div class="px-4 py-5 sm:p-6">
        <form method="GET" action="{{ route('admin.students.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Name, email, or ID">
                </div>

                <!-- Course Filter -->
                <div>
                    <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                    <select name="course" id="course"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Level Filter -->
                <div>
                    <label for="year_level" class="block text-sm font-medium text-gray-700 mb-1">Year Level</label>
                    <select name="year_level" id="year_level"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Levels</option>
                        @foreach($yearLevels as $level)
                            <option value="{{ $level }}" {{ request('year_level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-end space-x-3">
                <a href="{{ route('admin.students.index') }}"
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

<!-- Students Table -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Students ({{ $students->total() }})
        </h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Info</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Academic</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium">{{ substr($student->full_name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                <div class="text-xs text-gray-400">{{ $student->student_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $student->course ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-500">{{ $student->year_level ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $student->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $student->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.students.edit', $student) }}"
                               class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                               title="Edit Student">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.students.reset-password', $student) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200"
                                        title="Reset Password"
                                        onclick="return confirm('Are you sure you want to reset this student\\'s password?')">
                                    <i class="fas fa-key"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.students.delete', $student) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                        title="Delete Student"
                                        onclick="return confirm('Are you sure you want to delete this student? This action cannot be undone.')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Students Found</h3>
                        <p class="text-gray-500">No students match your search criteria.</p>
                        <a href="{{ route('admin.students.create') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-user-plus mr-2"></i> Add Your First Student
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($students->hasPages())
    <div class="px-4 py-4 border-t border-gray-200">
        {{ $students->links() }}
    </div>
    @endif
</div>
@endsection
