<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Management System')</title>
    @vite('resources/css/app.css', 'resources/js/app.js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen">
    @auth
        <!-- Navigation -->
            <nav class="bg-white text-gray-800 shadow-md border-b border-gray-200">
                <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 px-2">
                        <div class="flex items-center ml-60">
                            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('student.dashboard') }}"
                                class="text-xl font-bold flex items-center">
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Student Management System
                            </a>
                        </div>

                        <div class="flex items-center space-x-4 mr-4">
                            <span class="text-sm hidden sm:inline">
                                {{ Auth::user()->full_name }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm hover:text-primary-200 flex items-center transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

        <!-- Sidebar for Admin -->
        @if (Auth::user()->isAdmin())
            <div class="flex">
                <aside class="w-64 bg-white shadow-lg min-h-screen">
                    <nav class="mt-5">
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-tachometer-alt w-6"></i>
                            <span class="mx-4 font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.students.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.students*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-users w-6"></i>
                            <span class="mx-4 font-medium">Students</span>
                        </a>

                        <a href="{{ route('admin.grades.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.grades*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-graduation-cap w-6"></i>
                            <span class="mx-4 font-medium">Grades</span>
                        </a>

                        <a href="{{ route('admin.announcements.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.announcements*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-bullhorn w-6"></i>
                            <span class="mx-4 font-medium">Announcements</span>
                        </a>

                        <a href="{{ route('admin.reports.students') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.reports*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-chart-bar w-6"></i>
                            <span class="mx-4 font-medium">Reports</span>
                        </a>

                        <a href="{{ route('admin.activity-logs.index') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('admin.activity-logs*') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-history w-6"></i>
                            <span class="mx-4 font-medium">Activity Logs</span>
                        </a>
                    </nav>
                </aside>
                <main class="flex-1 p-6">
                    @yield('content')
                </main>
            </div>
        @else
            <!-- Student Navigation -->
            <div class="flex">
                <aside class="w-64 bg-white shadow-md min-h-screen">
                    <nav class="mt-5 fixed">
                        <a href="{{ route('student.dashboard') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('student.dashboard') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-tachometer-alt w-6"></i>
                            <span class="mx-4 font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('student.profile') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('student.profile') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-user w-6"></i>
                            <span class="mx-4 font-medium">Profile</span>
                        </a>

                        <a href="{{ route('student.grades') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('student.grades') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-graduation-cap w-6"></i>
                            <span class="mx-4 font-medium">Grades</span>
                        </a>

                        <a href="{{ route('student.announcements') }}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-primary-50 hover:text-primary-600 {{ request()->routeIs('student.announcements') ? 'bg-primary-50 text-primary-600 border-r-4 border-primary-600' : '' }}">
                            <i class="fas fa-bullhorn w-6"></i>
                            <span class="mx-4 font-medium">Announcements</span>
                        </a>
                    </nav>
                </aside>
                <main class="flex-1 p-6">
                    @yield('content')
                </main>
            </div>
        @endif
    @else
        <main>
            @yield('content')
        </main>
    @endauth

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flash-message">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flash-message">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="fixed top-4 right-4 bg-yellow-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flash-message">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('warning') }}
            </div>
        </div>
    @endif

    @if (session('temporary_password'))
        <div class="fixed bottom-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flash-message">
            <div class="flex items-center">
                <i class="fas fa-key mr-2"></i>
                Temporary Password: <strong class="ml-2">{{ session('temporary_password') }}</strong>
            </div>
        </div>
    @endif

    <script>
        // Auto-hide flash messages
        setTimeout(() => {
            const messages = document.querySelectorAll('.flash-message');
            messages.forEach(message => {
                message.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 300);
            });
        }, 5000);
    </script>
</body>

</html>
