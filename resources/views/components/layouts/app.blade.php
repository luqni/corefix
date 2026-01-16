<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Corefix.id - HP Service & Repair' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 pb-20"> <!-- Added pb-20 for bottom nav space -->
    <div class="min-h-screen flex flex-col">
        
        <!-- Mobile Header (Logo Only) -->
        <div class="bg-white shadow px-4 py-3 flex justify-center items-center sticky top-0 z-50">
            <a href="/" class="text-2xl font-black text-indigo-600 tracking-tighter">Corefix.id</a>
        </div>

        <!-- Desktop Navigation (Hidden on Mobile) -->
        <nav class="hidden md:block bg-white shadow mb-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="/" class="text-2xl font-bold text-indigo-600">Corefix.id</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="/" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md font-medium">Home</a>
                        <a href="{{ route('tracking') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md font-medium">Track Order</a>
                        
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 font-bold px-3 py-2 rounded-md">Admin Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-indigo-600 text-sm">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Mobile Bottom Navigation (Fixed) -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around items-center h-16 z-50 md:hidden pb-safe">
            <!-- Home -->
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full text-xs {{ request()->routeIs('home') ? 'text-indigo-600' : 'text-gray-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>

            <!-- Track -->
            <a href="{{ route('tracking') }}" class="flex flex-col items-center justify-center w-full h-full text-xs {{ request()->routeIs('tracking') ? 'text-indigo-600' : 'text-gray-500' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Track
            </a>

            <!-- Admin/Account -->
            @auth
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full text-xs text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Admin
                </a>
            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center justify-center w-full h-full text-xs text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            @endauth
        </div>

        <!-- Footer (Hidden on Mobile usually or kept minimal) -->
        <footer class="hidden md:block bg-gray-800 text-white py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} Corefix.id. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
