<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Welcome back, {{ auth()->user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('admin.dashboard') }}" class="block p-6 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition">
                            <h4 class="font-bold text-indigo-700 text-lg">Go to Admin Dashboard &rarr;</h4>
                            <p class="text-gray-600 mt-2">View statistics, revenue, and active tickets.</p>
                        </a>

                        <a href="{{ route('admin.orders') }}" class="block p-6 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                            <h4 class="font-bold text-gray-800 text-lg">Manage Orders &rarr;</h4>
                            <p class="text-gray-600 mt-2">Update status and verify payments.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
