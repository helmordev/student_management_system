@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Add New Student</h1>
            <p class="text-gray-600">Create a new student account</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Student Information</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Fill in the student's details. A temporary password will be generated automatically.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('admin.students.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="md:col-span-2">
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name *
                            </label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
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
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
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
                            <input type="text" name="course" id="course" value="{{ old('course') }}"
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
                                <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year
                                </option>
                                <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year
                                </option>
                                <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year
                                </option>
                                <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year
                                </option>
                                <option value="5th Year" {{ old('year_level') == '5th Year' ? 'selected' : '' }}>5th Year
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
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                Address
                            </label>
                            <textarea name="address" id="address" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Important Information
                                </h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>A temporary password will be automatically generated and displayed after creating the
                                        student account.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.students.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Create Student Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
