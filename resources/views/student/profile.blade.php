@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Student Profile</h1>
        <p class="text-gray-600">Manage your personal information</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Information -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Personal Information</h3>
                    <p class="mt-1 text-sm text-gray-500">Update your profile details</p>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form method="POST" action="{{ route('student.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student ID (Readonly) -->
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student
                                    ID</label>
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
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name
                                    *</label>
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
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address
                                    *</label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $student->email) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                    required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="md:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                    Number</label>
                                <input type="tel" name="phone" id="phone"
                                    value="{{ old('phone', $student->phone) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea name="address" id="address" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $student->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Account Status -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Account Status</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Status</span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Active
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Member Since</span>
                        <span class="text-sm text-gray-900">{{ $student->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Last Updated</span>
                        <span class="text-sm text-gray-900">{{ $student->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('student.change-password') }}"
                        class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-key text-blue-500 mr-3"></i>
                            <span class="text-sm font-medium text-gray-900">Change Password</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>

                    <a href="{{ route('student.grades') }}"
                        class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-md hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap text-green-500 mr-3"></i>
                            <span class="text-sm font-medium text-gray-900">View Grades</span>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
