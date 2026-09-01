<div>
    <!-- Page Header & Metrics -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pemasukan & Pengeluaran Kas</h2>
            <p class="text-sm text-gray-500 mt-1">Pencatatan arus kas dan biaya operasional di luar transaksi servis/order.</p>
        </div>
        <div class="flex items-center space-x-3">
            <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Catat Transaksi
            </button>
        </div>
    </div>

    <!-- Alert Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6 flex justify-between items-center">
            <span>{{ session('message') }}</span>
            <button type="button" class="text-green-700 hover:text-green-900 font-bold" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    <!-- Financial Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
        <!-- Total Income -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-emerald-500">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Total Pemasukan Lain</span>
                <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-gray-900 mt-2">
                Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-400 mt-1">Non-order revenue & capital</div>
        </div>

        <!-- Total Expense -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 border-rose-500">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-rose-600">Total Pengeluaran</span>
                <span class="p-2 bg-rose-50 text-rose-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-extrabold text-gray-900 mt-2">
                Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-400 mt-1">Operational & general expenses</div>
        </div>

        <!-- Net Cash Flow -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl p-5 border-l-4 {{ $netCashFlow >= 0 ? 'border-blue-500' : 'border-amber-500' }}">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider {{ $netCashFlow >= 0 ? 'text-blue-600' : 'text-amber-600' }}">
                    Arus Kas Bersih (Non-Order)
                </span>
                <span class="p-2 {{ $netCashFlow >= 0 ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600' }} rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-extrabold {{ $netCashFlow >= 0 ? 'text-blue-700' : 'text-rose-600' }} mt-2">
                Rp {{ number_format($netCashFlow, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-400 mt-1">Pemasukan dikurangi Pengeluaran</div>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-5 rounded-xl shadow-sm mb-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-center">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pencarian</label>
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari judul, kategori, catatan..." class="w-full pl-10 pr-4 py-2 text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tipe Transaksi</label>
                <select wire:model.live="typeFilter" class="w-full py-2 text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="all">Semua Tipe</option>
                    <option value="income">Pemasukan (+)</option>
                    <option value="expense">Pengeluaran (-)</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kategori</label>
                <select wire:model.live="categoryFilter" class="w-full py-2 text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="all">Semua Kategori</option>
                    @foreach($availableCategories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Filter -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Periode Waktu</label>
                <select wire:model.live="dateFilter" class="w-full py-2 text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="all">Semua Waktu</option>
                    <option value="today">Hari Ini</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                    <option value="last_month">Bulan Lalu</option>
                    <option value="year">Tahun Ini</option>
                    <option value="custom">Rentang Khusus</option>
                </select>
            </div>
        </div>

        <!-- Custom Date Range Picker (shown when custom is selected) -->
        @if($dateFilter === 'custom')
            <div class="pt-3 border-t border-gray-100 flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-600 font-medium">Dari:</span>
                    <input wire:model.live="startDate" type="date" class="py-1.5 px-3 text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-600 font-medium">Sampai:</span>
                    <input wire:model.live="endDate" type="date" class="py-1.5 px-3 text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        @endif
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase border-b border-gray-200">
                        <th wire:click="sortBy('transaction_date')" class="py-3.5 px-4 cursor-pointer hover:bg-gray-100">
                            Tanggal
                            @if($sortField === 'transaction_date')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <th class="py-3.5 px-4">Tipe</th>
                        <th class="py-3.5 px-4">Kategori & Judul</th>
                        <th class="py-3.5 px-4">Metode Bayar</th>
                        <th wire:click="sortBy('amount')" class="py-3.5 px-4 cursor-pointer hover:bg-gray-100">
                            Nominal (IDR)
                            @if($sortField === 'amount')
                                <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                            @endif
                        </th>
                        <th class="py-3.5 px-4">Petugas</th>
                        <th class="py-3.5 px-4 text-center">Bukti / Nota</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Tanggal -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-gray-600 font-medium">
                                {{ $trx->transaction_date->format('d M Y') }}
                            </td>

                            <!-- Tipe -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($trx->isIncome())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                        Pemasukan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                        Pengeluaran
                                    </span>
                                @endif
                            </td>

                            <!-- Kategori & Judul -->
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-gray-900">{{ $trx->title }}</div>
                                <div class="flex items-center space-x-2 mt-0.5">
                                    <span class="inline-flex items-center text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
                                        {{ $trx->category }}
                                    </span>
                                    @if($trx->description)
                                        <span class="text-xs text-gray-400 italic truncate max-w-xs" title="{{ $trx->description }}">
                                            • {{ Str::limit($trx->description, 40) }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Metode Bayar -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-gray-600 uppercase text-xs font-medium">
                                <span class="bg-gray-100 px-2 py-1 rounded-md text-gray-700">
                                    {{ $trx->payment_method }}
                                </span>
                            </td>

                            <!-- Nominal -->
                            <td class="py-3.5 px-4 whitespace-nowrap font-mono font-bold text-sm {{ $trx->isIncome() ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $trx->isIncome() ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>

                            <!-- Petugas -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-gray-500">
                                {{ $trx->user->name ?? '-' }}
                            </td>

                            <!-- Bukti -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-center">
                                @if($trx->attachment)
                                    <button wire:click="viewAttachment({{ $trx->id }})" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 text-xs font-semibold underline">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        Lihat Nota
                                    </button>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-right space-x-2">
                                <button wire:click="edit({{ $trx->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase transition">
                                    Edit
                                </button>
                                <button wire:confirm="Apakah Anda yakin ingin menghapus catatan transaksi ini?" wire:click="delete({{ $trx->id }})" class="text-rose-600 hover:text-rose-900 font-bold text-xs uppercase transition">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400 italic">
                                Belum ada transaksi tercatat untuk kriteria pencarian ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Form Tambah / Edit Transaksi -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="store">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900" id="modal-title">
                                {{ $transactionId ? 'Edit Transaksi Keuangan' : 'Catat Transaksi Keuangan Baru' }}
                            </h3>
                            <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Type Selection -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jenis Transaksi</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="flex items-center justify-center p-3 border rounded-lg cursor-pointer transition {{ $type === 'income' ? 'border-emerald-500 bg-emerald-50 text-emerald-800 font-bold ring-2 ring-emerald-400' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                                        <input type="radio" wire:model.live="type" value="income" class="sr-only">
                                        <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                        </svg>
                                        Pemasukan (+)
                                    </label>
                                    <label class="flex items-center justify-center p-3 border rounded-lg cursor-pointer transition {{ $type === 'expense' ? 'border-rose-500 bg-rose-50 text-rose-800 font-bold ring-2 ring-rose-400' : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                                        <input type="radio" wire:model.live="type" value="expense" class="sr-only">
                                        <svg class="w-4 h-4 mr-2 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                        </svg>
                                        Pengeluaran (-)
                                    </label>
                                </div>
                                @error('type') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Judul Transaksi -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Judul / Uraian Singkat *</label>
                                <input type="text" wire:model="title" placeholder="Contoh: Beli Obeng Set, Pembayaran Token Listrik, dll." class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                @error('title') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kategori *</label>
                                <select wire:model.live="category" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Pilih Kategori --</option>
                                    @if($type === 'income')
                                        @foreach($defaultIncomeCategories as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    @else
                                        @foreach($defaultExpenseCategories as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    @endif
                                    <option value="custom">+ Tulis Kategori Lainnya</option>
                                </select>
                                @error('category') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror

                                @if($category === 'custom')
                                    <div class="mt-2">
                                        <input type="text" wire:model="customCategory" placeholder="Ketik nama kategori baru..." class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-amber-50">
                                        @error('customCategory') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>

                            <!-- Grid: Nominal & Tanggal -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Nominal -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nominal (Rp) *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 font-bold text-xs">Rp</div>
                                        <input type="number" wire:model="amount" placeholder="0" class="w-full pl-9 text-sm font-mono font-bold border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    @error('amount') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <!-- Tanggal -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tanggal Transaksi *</label>
                                    <input type="date" wire:model="transaction_date" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('transaction_date') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Metode Bayar -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Metode Pembayaran</label>
                                <select wire:model="payment_method" class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="cash">Tunai / Kasir (Cash)</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="qris">QRIS / E-Wallet</option>
                                    <option value="other">Lainnya</option>
                                </select>
                                @error('payment_method') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Keterangan / Catatan -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Catatan Tambahan (Opsional)</label>
                                <textarea wire:model="description" rows="2" placeholder="Catatan detail atau nomor referensi faktur/struk..." class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                @error('description') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Lampiran Nota / Bukti -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Upload Bukti / Nota (Foto/PDF)</label>
                                <input type="file" wire:model="attachment" accept="image/*,application/pdf" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <div wire:loading wire:target="attachment" class="text-xs text-indigo-600 mt-1 font-semibold">Mengunggah berkas...</div>
                                @error('attachment') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror

                                @if($existingAttachment && !$attachment)
                                    <div class="mt-2 text-xs text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Berkas nota telah diupload sebelumnya.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm disabled:opacity-50">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Lihat Bukti / Lampiran -->
    @if($isAttachmentModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-preview" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity" aria-hidden="true" wire:click="closeAttachmentModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h4 class="text-sm font-bold text-gray-900">Nota / Bukti: {{ $viewingAttachmentName }}</h4>
                        <button wire:click="closeAttachmentModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4 flex justify-center bg-gray-100 max-h-[75vh] overflow-auto">
                        @if(Str::endsWith(strtolower($viewingAttachmentUrl), ['.pdf']))
                            <iframe src="{{ $viewingAttachmentUrl }}" class="w-full h-96 rounded border"></iframe>
                        @else
                            <img src="{{ $viewingAttachmentUrl }}" alt="Bukti Transaksi" class="max-w-full h-auto rounded-lg shadow-sm">
                        @endif
                    </div>
                    <div class="bg-white px-6 py-3 border-t border-gray-200 flex justify-between items-center">
                        <a href="{{ $viewingAttachmentUrl }}" target="_blank" download class="text-xs font-bold text-indigo-600 hover:text-indigo-800 underline flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh Berkas
                        </a>
                        <button wire:click="closeAttachmentModal" class="px-4 py-1.5 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
