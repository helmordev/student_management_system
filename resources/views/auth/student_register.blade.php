<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Student Management System</title>

    @vite('resources/css/app.css', 'resources/js/app.js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Left Side - Branding -->
        <div class="bg-gradient-primary md:w-1/2 flex items-center justify-center p-8 text-white">
            <div class="max-w-md text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-graduate text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl font-bold mb-4">Student Registration</h1>
                <p class="text-xl opacity-90">Join our academic community and start your educational journey</p>
                <div class="mt-8 space-y-4 text-left">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-3"></i>
                        <span>Access to personalized dashboard</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-3"></i>
                        <span>View grades and academic progress</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-3"></i>
                        <span>Receive important announcements</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-3"></i>
                        <span>Secure and easy to use</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="md:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Create Student Account</h2>
                    <p class="text-gray-600 mt-2">Fill in your details to get started</p>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white shadow-lg rounded-lg p-8">
                    <form method="POST" action="{{ route('student.register.submit') }}">
                        @csrf

                        <div class="space-y-6">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-blue-500"></i>
                                    Full Name
                                </label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('full_name') border-red-500 @enderror"
                                       placeholder="Enter your full name" required autocomplete="name" autofocus>
                                @error('full_name')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-blue-500"></i>
                                    Email Address
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('email') border-red-500 @enderror"
                                       placeholder="Enter your email address" required autocomplete="email">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-blue-500"></i>
                                    Password
                                </label>
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('password') border-red-500 @enderror"
                                       placeholder="Create a password" required>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">
                                    Password must be at least 8 characters long
                                </p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-blue-500"></i>
                                    Confirm Password
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                       placeholder="Confirm your password" required>
                            </div>

                            <!-- Password Requirements -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                                    <i class="fas fa-shield-alt mr-2"></i>
                                    Password Requirements
                                </h4>
                                <ul class="text-xs text-blue-700 space-y-1">
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

                            <!-- Terms and Conditions -->
                            <div class="mt-6">
                                <label for="terms" class="flex items-center">
                                    <input type="checkbox" name="terms" id="terms"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-600">
                                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms and Conditions</a>
                                    </span>
                                </label>
                                @error('terms')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="w-full bg-gradient-primary text-white py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 font-semibold text-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mt-6">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create Account
                            </button>
                        </div>
                    </form>

                    <!-- Login Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-semibold">
                                Sign In Here
                            </a>
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-gray-500 text-sm">
                    <p>&copy; {{ date('Y') }} Student Management System. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const requirements = document.querySelectorAll('.text-blue-700 li');

        passwordInput.addEventListener('input', function() {
            const password = this.value;

            requirements.forEach(req => {
                const icon = req.querySelector('i');
                const text = req.textContent.toLowerCase();

                if (text.includes('8 characters') && password.length >= 8) {
                    icon.className = 'fas fa-check-circle text-green-500 mr-2';
                } else if (text.includes('8 characters')) {
                    icon.className = 'fas fa-times-circle text-red-500 mr-2';
                }

                if (text.includes('uppercase') && /[A-Z]/.test(password) && /[a-z]/.test(password)) {
                    icon.className = 'fas fa-check-circle text-green-500 mr-2';
                } else if (text.includes('uppercase')) {
                    icon.className = 'fas fa-times-circle text-red-500 mr-2';
                }

                if (text.includes('numbers') && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                    icon.className = 'fas fa-check-circle text-green-500 mr-2';
                } else if (text.includes('numbers')) {
                    icon.className = 'fas fa-times-circle text-red-500 mr-2';
                }
            });
        });

        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const messages = document.querySelectorAll('.bg-green-100, .bg-red-100');
            messages.forEach(message => {
                message.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>
