@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Student</h1>
            <p class="text-gray-600">Update student information</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Edit Student: {{ $student->full_name }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Update the student's details and account status.
                </p>
            </div>

            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('admin.students.update', $student) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student ID (Readonly) -->
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student ID</label>
                            <input type="text" id="student_id" value="{{ $student->student_id }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed"
                                readonly>
                            <p class="text-xs text-gray-500 mt-1">Student ID cannot be changed</p>
                        </div>

                        <!-- Academic Year (Readonly) -->
                        <div>
                            <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic
                                Year</label>
                            <input type="text" id="academic_year" value="{{ $student->academic_year }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed"
                                readonly>
                        </div>

                        <!-- Full Name -->
                        <div class="md:col-span-2">
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name *
                            </label>
                            <input type="text" name="full_name" id="full_name"
                                value="{{ old('full_name', $student->full_name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('full_name') border-red-500 @enderror"
                                required>
                            @error('full_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email Address *
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Course -->
                        <div>
                            <label for="course" class="block text-sm font-medium text-gray-700 mb-1">
                                Course *
                            </label>
                            <input type="text" name="course" id="course"
                                value="{{ old('course', $student->course) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('course') border-red-500 @enderror"
                                required>
                            @error('course')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Year Level -->
                        <div>
                            <label for="year_level" class="block text-sm font-medium text-gray-700 mb-1">
                                Year Level *
                            </label>
                            <select name="year_level" id="year_level"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('year_level') border-red-500 @enderror"
                                required>
                                <option value="">Select Year Level</option>
                                <option value="1st Year"
                                    {{ old('year_level', $student->year_level) == '1st Year' ? 'selected' : '' }}>1st Year
                                </option>
                                <option value="2nd Year"
                                    {{ old('year_level', $student->year_level) == '2nd Year' ? 'selected' : '' }}>2nd Year
                                </option>
                                <option value="3rd Year"
                                    {{ old('year_level', $student->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year
                                </option>
                                <option value="4th Year"
                                    {{ old('year_level', $student->year_level) == '4th Year' ? 'selected' : '' }}>4th Year
                                </option>
                                <option value="5th Year"
                                    {{ old('year_level', $student->year_level) == '5th Year' ? 'selected' : '' }}>5th Year
                                </option>
                            </select>
                            @error('year_level')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Phone Number
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $student->phone) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">
                                Account Status
                            </label>
                            <select name="is_active" id="is_active"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="1" {{ old('is_active', $student->is_active) ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ !old('is_active', $student->is_active) ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                Address
                            </label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $student->address) }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.students.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Update Student
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="mt-6 bg-white shadow rounded-lg border border-red-200">
            <div class="px-4 py-5 sm:px-6 border-b border-red-200">
                <h3 class="text-lg leading-6 font-medium text-red-600">Danger Zone</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Reset Password</h4>
                        <p class="text-sm text-gray-500">
                            Reset this student's password. A new temporary password will be generated.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('admin.students.reset-password', $student) }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 border border-yellow-300 rounded-md shadow-sm text-sm font-medium text-yellow-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200"
                            onclick="return confirm('Are you sure you want to reset this student\'s password?')">
                            Reset Password
                        </button>
                    </form>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Delete Student</h4>
                        <p class="text-sm text-gray-500">
                            Permanently delete this student account. This action cannot be undone.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('admin.students.delete', $student) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200"
                            onclick="return confirm('Are you sure you want to delete this student? This action cannot be undone.')">
                            Delete Student
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
