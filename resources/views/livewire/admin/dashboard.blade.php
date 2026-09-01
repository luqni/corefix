<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Ringkasan Dashboard</h2>
            <p class="text-xs text-gray-500 mt-0.5">Pantau status pengerjaan servis, stok suku cadang, dan performa keuangan toko.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <select wire:model.live="dateFilter" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                <option value="all">Semua Waktu</option>
                <option value="today">Hari Ini</option>
                <option value="week">Minggu Ini</option>
                <option value="month">Bulan Ini</option>
                <option value="last_month">Bulan Lalu</option>
                <option value="year">Tahun Ini</option>
            </select>

            @if(auth()->user()->hasRole(['super_admin', 'admin']))
            <button wire:click="exportExcel" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span wire:loading.remove wire:target="exportExcel">Export Excel</span>
                <span wire:loading wire:target="exportExcel">Mengunduh...</span>
            </button>
            @endif
        </div>
    </div>

    <!-- Status Order Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <!-- Pending -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 border-gray-800">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Order Masuk (Pending)</div>
            <div class="text-3xl font-black text-gray-900 mt-2">{{ $pending }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5">Menunggu konfirmasi/diagnosa</div>
        </div>

        <!-- In Process -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 border-indigo-500">
            <div class="text-indigo-600 text-xs uppercase font-bold tracking-wider">Sedang Dikerjakan</div>
            <div class="text-3xl font-black text-indigo-600 mt-2">{{ $process }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5">Dalam proses perbaikan</div>
        </div>

        <!-- Completed -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 border-green-500">
            <div class="text-green-600 text-xs uppercase font-bold tracking-wider">Selesai (Done)</div>
            <div class="text-3xl font-black text-green-600 mt-2">{{ $completed }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5">Servis selesai siap diambil</div>
        </div>

        <!-- Cancelled & Refunded -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 border-rose-500">
            <div class="text-rose-600 text-xs uppercase font-bold tracking-wider">Batal & Refund</div>
            <div class="text-3xl font-black text-rose-600 mt-2">{{ $cancelledCount + $refundedCount }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5">{{ $cancelledCount }} batal • {{ $refundedCount }} refund</div>
        </div>

        @if(auth()->user()->hasRole(['super_admin', 'admin']))
        <!-- Revenue -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 border-yellow-500">
            <div class="text-yellow-600 text-xs uppercase font-bold tracking-wider">Total Pendapatan Order</div>
            <div class="text-2xl font-black text-gray-900 mt-2">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5">Dari transaksi order lunas</div>
        </div>
        @endif
    </div>

    <!-- Peringatan Stok Suku Cadang Menipis / Habis (Stok <= 1) -->
    @if(auth()->user()->hasRole(['super_admin', 'admin']))
    <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 mb-8 border {{ $lowStockSpareParts->isNotEmpty() ? 'border-rose-200 bg-gradient-to-br from-rose-50/40 to-white' : 'border-emerald-200 bg-gradient-to-br from-emerald-50/40 to-white' }}">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-3 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 rounded-lg {{ $lowStockSpareParts->isNotEmpty() ? 'bg-rose-600 text-white' : 'bg-emerald-600 text-white' }}">
                    @if($lowStockSpareParts->isNotEmpty())
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    @else
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <span>Peringatan Stok Suku Cadang Menipis / Habis (Sisa &le; 1 Pcs)</span>
                        @if($lowStockSpareParts->isNotEmpty())
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-black bg-rose-100 text-rose-800 border border-rose-300">
                                {{ $lowStockSpareParts->count() }} Item Perlu Restock
                            </span>
                        @endif
                    </h3>
                    <p class="text-xs text-gray-500">Daftar suku cadang yang stok fisiknya habis (0) atau tersisa 1 pcs agar segera dilakukan pengadaan/restock.</p>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.spareparts') }}" class="inline-flex items-center px-3.5 py-1.5 border border-indigo-600 text-xs font-bold rounded-md text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition shadow-sm">
                    Kelola Semua Stok Suku Cadang &rarr;
                </a>
            </div>
        </div>

        @if($lowStockSpareParts->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/80 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-2.5">Kode SKU</th>
                            <th class="px-4 py-2.5">Nama Suku Cadang</th>
                            <th class="px-4 py-2.5">Kategori</th>
                            <th class="px-4 py-2.5 text-center">Sisa Stok</th>
                            <th class="px-4 py-2.5 text-right">Harga Modal (HPP)</th>
                            <th class="px-4 py-2.5 text-right">Harga Jual</th>
                            <th class="px-4 py-2.5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-xs">
                        @foreach($lowStockSpareParts as $part)
                            <tr class="hover:bg-rose-50/40 transition">
                                <td class="px-4 py-3 font-mono font-bold text-indigo-600">
                                    {{ $part->item_code }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $part->name }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $part->type->name ?? $part->type }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full font-black text-xs font-mono
                                        {{ $part->stock == 0 ? 'bg-rose-100 text-rose-800 border border-rose-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                                        {{ $part->stock }} pcs
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-mono text-gray-600">
                                    Rp {{ number_format($part->capital_price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right font-mono font-bold text-gray-900">
                                    Rp {{ number_format($part->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($part->stock == 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-extrabold bg-red-600 text-white animate-pulse">
                                            STOK HABIS
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-500 text-white">
                                            SISA 1 PCS (KRITIS)
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800 text-xs">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">Semua stok suku cadang dalam kondisi aman (tidak ada sparepart dengan sisa stok &le; 1 pcs).</span>
            </div>
        @endif
    </div>
    @endif

    @if(auth()->user()->hasRole(['super_admin', 'admin']))
    <!-- Net Profit & Financial Overview Rows -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Net Profit Sparepart -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 border-blue-500">
            <div class="text-blue-600 text-xs uppercase font-bold tracking-wider">Laba Bersih Sparepart</div>
            <div class="text-2xl font-black {{ $sparepartProfit >= 0 ? 'text-blue-700' : 'text-rose-600' }} mt-2">
                Rp {{ number_format($sparepartProfit, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-500 mt-1">Margin jual dikurangi modal part</div>
        </div>

        <!-- Net Profit Service -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 border-teal-500">
            <div class="text-teal-600 text-xs uppercase font-bold tracking-wider">Laba Bersih Jasa Servis</div>
            <div class="text-2xl font-black {{ $serviceProfit >= 0 ? 'text-teal-700' : 'text-rose-600' }} mt-2">
                Rp {{ number_format($serviceProfit, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-500 mt-1">Margin tarif jasa servis</div>
        </div>

        <!-- Non-order Expense -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 border-rose-500">
            <div class="text-rose-600 text-xs uppercase font-bold tracking-wider">Biaya Operasional Toko</div>
            <div class="text-2xl font-black text-rose-700 mt-2">Rp {{ number_format($otherExpense, 0, ',', '.') }}</div>
            <div class="text-xs text-gray-500 mt-1">Pengeluaran kas non-order</div>
        </div>

        <!-- Overall Net Profit -->
        <div class="bg-white overflow-hidden shadow sm:rounded-lg p-5 border-l-4 {{ $netBusinessProfit >= 0 ? 'border-emerald-500' : 'border-red-600' }}">
            <div class="text-xs uppercase font-bold tracking-wider {{ $netBusinessProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                Total Laba Bersih Usaha
            </div>
            <div class="text-2xl font-black mt-2 {{ $netBusinessProfit >= 0 ? 'text-emerald-700' : 'text-red-600' }}">
                Rp {{ number_format($netBusinessProfit, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-500 mt-1">Laba order + kas lain - operasional</div>
        </div>
    </div>

    <!-- Integrated Profit & Loss Statement Card -->
    <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6 mb-8 border border-gray-100">
        <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Laporan Laba Rugi Terpadu</h3>
                <p class="text-xs text-gray-500">Perhitungan kalkulasi profit yang menghubungkan seluruh transaksi order servis, kerugian cancel/refund, dan beban operasional toko.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                Otomatis & Real-time
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pemasukan & Pendapatan -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h4 class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    1. Pendapatan & Pemasukan (+)
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Penjualan Sparepart (Order)</span>
                        <span class="font-mono text-gray-900">Rp {{ number_format($sparepartRevenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Jasa Servis & Perbaikan (Order)</span>
                        <span class="font-mono text-gray-900">Rp {{ number_format($serviceRevenue, 0, ',', '.') }}</span>
                    </div>
                    @if($orderTotalDiscount > 0)
                    <div class="flex justify-between text-rose-600">
                        <span>Potongan Diskon / Kupon Promo</span>
                        <span class="font-mono">- Rp {{ number_format($orderTotalDiscount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-gray-600">
                        <span>Pemasukan Kas Lainnya (Non-Order)</span>
                        <span class="font-mono text-gray-900">Rp {{ number_format($otherIncome, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-2 border-t border-gray-300 flex justify-between font-bold text-gray-900">
                        <span>Total Pemasukan Kas</span>
                        <span class="font-mono text-emerald-700">Rp {{ number_format($revenue + $otherIncome, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Beban & Pengeluaran -->
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <h4 class="text-xs font-bold text-rose-800 uppercase tracking-wider mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                    2. Beban & Biaya Operasional (-)
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>HPP / Modal Sparepart Terpakai</span>
                        <span class="font-mono text-gray-900">Rp {{ number_format($sparepartCapital, 0, ',', '.') }}</span>
                    </div>
                    @if($serviceCapital > 0)
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Pokok Jasa Servis</span>
                        <span class="font-mono text-gray-900">Rp {{ number_format($serviceCapital, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($cancelledLoss > 0)
                    <div class="flex justify-between text-rose-600 font-medium">
                        <span>Kerugian Modal Order Cancel/Refund</span>
                        <span class="font-mono">- Rp {{ number_format($cancelledLoss, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Operasional Toko (Sewa, Listrik, Gaji, dll.)</span>
                        <span class="font-mono text-gray-900">Rp {{ number_format($otherExpense, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-2 border-t border-gray-300 flex justify-between font-bold text-gray-900">
                        <span>Total Beban Biaya</span>
                        <span class="font-mono text-rose-700">Rp {{ number_format($sparepartCapital + $serviceCapital + $otherExpense, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grand Total Summary Row -->
        <div class="mt-4 p-4 rounded-xl {{ $netBusinessProfit >= 0 ? 'bg-emerald-50 border border-emerald-200' : 'bg-rose-50 border border-rose-200' }} flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 rounded-lg {{ $netBusinessProfit >= 0 ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white' }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-bold text-gray-900">Laba Bersih Akhir (Net Profit Usaha)</div>
                    <div class="text-xs text-gray-500">Sudah dikurangi modal sparepart (termasuk part hangus/cancel), diskon voucher, dan seluruh biaya operasional kas toko.</div>
                </div>
            </div>
            <div class="text-2xl font-black font-mono {{ $netBusinessProfit >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                Rp {{ number_format($netBusinessProfit, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Tren Pendapatan</h3>
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
                    name: "Pendapatan (Rp)",
                    data: @json($chartData['data'])
                }],
                chart: {
                    type: 'area',
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
                colors: ['#2267BC']
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
                    name: 'Pendapatan (Rp)',
                    data: newData.data
                }]);
            });
        });
    </script>
    @endpush
    @endif
</div>
