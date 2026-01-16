<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-blue-900 to-indigo-900 relative overflow-hidden">
            
            <!-- Background Decoration -->
            <div class="absolute inset-0 z-0">
                 <div class="absolute inset-0 bg-indigo-900 opacity-50"></div>
                 <svg class="absolute bottom-0 left-0 transform translate-y-10" width="100%" height="200" fill="none" viewBox="0 0 1440 320">
                    <path fill="#ffffff" fill-opacity="0.05" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,197.3C1248,171,1344,149,1392,138.7L1440,128V320H1392C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320H0V224Z"></path>
                 </svg>
            </div>

            <div class="relative z-10 w-full sm:max-w-md">
                <div class="flex flex-col items-center mb-6">
                    <a href="/" wire:navigate class="text-3xl font-extrabold text-white tracking-wider flex items-center gap-2">
                        <span>🔧</span> COREFIX
                    </a>
                    <p class="text-indigo-200 text-sm mt-2">Professional Gadget Repair</p>
                </div>

                <div class="w-full px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl ring-1 ring-white/10 backdrop-blur-sm">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
