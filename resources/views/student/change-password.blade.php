@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Change Password</h1>
            <p class="text-gray-600">Secure your account with a new password</p>
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Password</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Ensure your account is using a long, random password to stay secure.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('student.change-password.submit') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                Current Password *
                            </label>
                            <input type="password" name="current_password" id="current_password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror"
                                required autocomplete="current-password">
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                                New Password *
                            </label>
                            <input type="password" name="new_password" id="new_password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('new_password') border-red-500 @enderror"
                                required autocomplete="new-password">
                            @error('new_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Password must be at least 8 characters long.
                            </p>
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirm New Password *
                            </label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required autocomplete="new-password">
                        </div>

                        <!-- Password Requirements -->
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <h4 class="text-sm font-medium text-blue-800 mb-2">Password Requirements</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    At least 8 characters long
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Include uppercase and lowercase letters
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Include numbers and special characters
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('student.profile') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
