<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        <div>
            <select wire:model.live="dateFilter" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-sm">
                <option value="all">Semua Waktu</option>
                <option value="today">Hari Ini</option>
                <option value="week">Minggu Ini</option>
                <option value="month">Bulan Ini</option>
                <option value="year">Tahun Ini</option>
            </select>
        </div>
    </div>
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

        @if(auth()->user()->hasRole(['super_admin', 'admin']))
        <!-- Revenue -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-yellow-500">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Total Revenue</div>
            <div class="text-3xl font-black text-gray-900 mt-2">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
        </div>
        @endif
    </div>

    @if(auth()->user()->hasRole(['super_admin', 'admin']))
    <!-- Net Profit Rows -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Net Profit Sparepart -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-blue-500">
            <div class="text-blue-500 text-xs uppercase font-bold tracking-wider">Net Profit (Spareparts)</div>
            <div class="text-3xl font-black text-blue-700 mt-2">Rp {{ number_format($sparepartProfit, 0, ',', '.') }}</div>
            <div class="text-sm text-gray-500 mt-2 italic">From completed & paid tickets.</div>
        </div>

        <!-- Net Profit Service -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 border-l-4 border-teal-500">
            <div class="text-teal-500 text-xs uppercase font-bold tracking-wider">Net Profit (Services)</div>
            <div class="text-3xl font-black text-teal-700 mt-2">Rp {{ number_format($serviceProfit, 0, ',', '.') }}</div>
            <div class="text-sm text-gray-500 mt-2 italic">From completed & paid tickets.</div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Revenue Trend</h3>
        <div id="revenueChart" style="min-height: 350px;"></div>
    </div>
    @endif

    @if(auth()->user()->hasRole(['super_admin', 'admin']))
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let options = {
                series: [{
                    name: "Revenue (Rp)",
                    data: @json($chartData['data'])
                }],
                chart: {
                    type: 'area', /* Use area chart for sleek look */
                    height: 350,
                    toolbar: { show: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: @json($chartData['labels']),
                    tooltip: { enabled: false }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#2267BC'] /* Use our secondary blue color */
            };

            let chart = new ApexCharts(document.querySelector("#revenueChart"), options);
            chart.render();

            Livewire.on('update-chart', (payload) => {
                let newData = payload[0]?.chartData || payload.chartData || payload;
                if (!newData || !newData.labels) return;
                
                chart.updateOptions({
                    xaxis: { categories: newData.labels }
                });
                chart.updateSeries([{
                    name: 'Revenue (Rp)',
                    data: newData.data
                }]);
            });
        });
    </script>
    @endpush
    @endif
</div>
