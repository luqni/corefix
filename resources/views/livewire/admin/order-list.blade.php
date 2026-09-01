<div>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="p-6 text-gray-900">
            
            <!-- Filters & Actions -->
            <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50 p-4 rounded-lg">
                <div class="flex flex-col md:flex-row w-full md:w-3/4 gap-4 mb-4 md:mb-0">
                    <div class="w-full md:w-1/3">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Cari Pesanan</label>
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Nama, No. WA, ID Tiket, Tipe HP..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full block text-sm">
                    </div>
                    <div class="w-full md:w-1/3">
                         <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Status</label>
                        <select wire:model.live="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full block text-sm">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu (Pending)</option>
                            <option value="received">Unit Diterima (Received)</option>
                            <option value="diagnosing">Diagnosa / Cek (Diagnosing)</option>
                            <option value="waiting_approval">Menunggu Persetujuan Pelanggan</option>
                            <option value="repairing">Sedang Dikerjakan (Repairing)</option>
                            <option value="payment_verification">Verifikasi Pembayaran</option>
                            <option value="done">Selesai (Done)</option>
                            <option value="cancelled">Dibatalkan (Cancelled)</option>
                            <option value="refunded">Refund (Retur Dana)</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/3">
                         <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Periode</label>
                        <select wire:model.live="dateFilter" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full block text-sm">
                            <option value="all">Semua Waktu</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="year">Tahun Ini</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500 hidden md:inline">
                        Halaman <strong>{{ $tickets->currentPage() }}</strong> dari <strong>{{ $tickets->lastPage() }}</strong> 
                        (Total: <strong>{{ $tickets->total() }}</strong>)
                    </span>
                    @if(auth()->user()->hasRole(['super_admin', 'admin']))
                    <a href="{{ route('admin.orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        + Buat Pesanan Baru
                    </a>
                    @endif
                </div>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-left border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-50 uppercase text-xs font-bold text-gray-500 border-b">
                            <th class="p-4 tracking-wider">Tanggal</th>
                            <th class="p-4 tracking-wider">ID Tiket</th>
                            <th class="p-4 tracking-wider">Pelanggan</th>
                            <th class="p-4 tracking-wider">Perangkat</th>
                            <th class="p-4 tracking-wider">Status Servis</th>
                            <th class="p-4 tracking-wider">Pembayaran</th>
                            <th class="p-4 tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-4 text-sm font-medium text-gray-600">{{ $ticket->created_at->format('d M Y') }}</td>
                                <td class="p-4 text-sm font-mono text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <span>{{ substr($ticket->id, 0, 8) }}</span>
                                        <button 
                                            x-data
                                            x-on:click="navigator.clipboard.writeText('{{ route('tracking', $ticket->id) }}'); $el.classList.add('text-green-600'); setTimeout(() => $el.classList.remove('text-green-600'), 1000);"
                                            title="Salin Link Pelacakan"
                                            class="text-gray-400 hover:text-indigo-600 transition"
                                        >
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="p-4 text-sm">
                                    <div class="font-bold text-gray-800">{{ $ticket->customer_name }}</div>
                                    <div class="text-xs text-gray-400">{{ $ticket->customer_wa }}</div>
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $ticket->device_model }}</td>
                                <td class="p-4">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold uppercase rounded-md 
                                        {{ match($ticket->status) {
                                            'done' => 'bg-green-100 text-green-700 border border-green-200',
                                            'cancelled' => 'bg-red-100 text-red-700 border border-red-200',
                                            'refunded' => 'bg-purple-100 text-purple-700 border border-purple-200',
                                            'pending' => 'bg-gray-100 text-gray-600 border border-gray-200',
                                            default => 'bg-indigo-50 text-indigo-700 border border-indigo-200'
                                        } }}">
                                        {{ match($ticket->status) {
                                            'pending' => 'Pending',
                                            'received' => 'Unit Diterima',
                                            'diagnosing' => 'Diagnosa',
                                            'waiting_approval' => 'Menunggu Approval',
                                            'repairing' => 'Sedang Dikerjakan',
                                            'payment_verification' => 'Verifikasi Bayar',
                                            'done' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                            'refunded' => 'Refund',
                                            default => str_replace('_', ' ', $ticket->status)
                                        } }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-bold uppercase rounded-md 
                                        {{ match($ticket->payment_status) {
                                            'paid' => 'bg-green-100 text-green-700 border border-green-200',
                                            'unpaid' => 'bg-red-50 text-red-600 border border-red-200',
                                            'waiting_verification' => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                                            'refunded' => 'bg-purple-50 text-purple-700 border border-purple-200',
                                            default => 'bg-gray-50 text-gray-700 border border-gray-200'
                                        } }}">
                                        {{ match($ticket->payment_status) {
                                            'paid' => 'Lunas',
                                            'unpaid' => 'Belum Bayar',
                                            'waiting_verification' => 'Menunggu Verifikasi',
                                            'refunded' => 'Refund',
                                            default => str_replace('_', ' ', $ticket->payment_status)
                                        } }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm whitespace-nowrap">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-wide border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 transition mr-2">Detail & Kelola</a>
                                    
                                    @if(auth()->user()->isSuperAdmin())
                                    <button onclick="confirm('Apakah Anda yakin ingin menghapus tiket order ini beserta seluruh riwayat pengerjaannya?') || event.stopImmediatePropagation()" wire:click="deleteOrder('{{ $ticket->id }}')" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-wide border border-red-200 px-3 py-1 rounded hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500 italic">Tidak ada data pesanan yang sesuai kriteria pencarian/filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500">
                <div class="mb-4 sm:mb-0">
                    Menampilkan <strong>{{ $tickets->firstItem() ?? 0 }}</strong> sampai <strong>{{ $tickets->lastItem() ?? 0 }}</strong> dari <strong>{{ $tickets->total() }}</strong> data
                </div>
                <div class="w-full sm:w-auto overflow-x-auto">
                    {{ $tickets->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
