<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management System</title>
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
                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl font-bold mb-4">Student Management System</h1>
                <p class="text-xl opacity-90">Comprehensive platform for academic management and student success</p>
                <div class="mt-8 grid grid-cols-2 gap-4 text-left">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-2"></i>
                        <span>Student Portal</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-2"></i>
                        <span>Grade Management</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-2"></i>
                        <span>Admin Dashboard</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-300 mr-2"></i>
                        <span>Real-time Updates</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="md:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                    <p class="text-gray-600 mt-2">Sign in to your account</p>
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

                @if(session('warning'))
                    <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        {{ session('warning') }}
                    </div>
                @endif

                <div class="bg-white shadow-lg rounded-lg p-8">
                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="space-y-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-blue-500"></i>
                                    Email Address
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('email') border-red-500 @enderror"
                                       placeholder="Enter your email address" required autocomplete="email" autofocus>
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
                                       placeholder="Enter your password" required autocomplete="current-password">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input type="checkbox" name="remember" id="remember"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                                        Remember me
                                    </label>
                                </div>
                           </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="w-full bg-gradient-primary text-white py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 font-semibold text-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Sign In
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="{{ route('student.register') }}" class="text-blue-600 hover:text-blue-500 font-semibold">
                                Register
                            </a>
                        </p>
                    </div>
                </div>

                <div class="mt-8 text-center text-gray-500 text-sm">
                    <p>&copy; {{ date('Y') }} Student Management System. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const messages = document.querySelectorAll('.bg-green-100, .bg-red-100, .bg-yellow-100');
            messages.forEach(message => {
                message.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>
