<div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Pending -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-gray-800">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Pending Requests</div>
            <div class="text-3xl font-black text-gray-900 mt-2">{{ $pending }}</div>
        </div>

        <!-- In Process -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-indigo-500">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">In Repair</div>
            <div class="text-3xl font-black text-indigo-600 mt-2">{{ $process }}</div>
        </div>

        <!-- Completed -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-green-500">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Completed</div>
            <div class="text-3xl font-black text-green-600 mt-2">{{ $completed }}</div>
        </div>

        <!-- Revenue -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-yellow-500">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Total Revenue</div>
            <div class="text-3xl font-black text-gray-900 mt-2">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
        </div>
    </div>
</div>
