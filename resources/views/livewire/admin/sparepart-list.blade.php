<div>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <!-- Header & Actions -->
            <div class="mb-6 flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $title ?? 'Stok Suku Cadang' }}</h3>
                    <p class="text-xs text-gray-500">Kelola stok suku cadang, kode QR barcode, dan filter per kategori.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Filter Category -->
                    <select wire:model.live="selectedCategory" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Semua Kategori ({{ $types->count() }})</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>

                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau kode SKU..." class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm w-48 sm:w-60">
                    
                    <button wire:click="create" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm font-semibold whitespace-nowrap shadow-sm">
                        + Tambah Suku Cadang
                    </button>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 shadow mb-6 rounded-r relative">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-left border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-50 uppercase text-xs font-bold text-gray-500 border-b">
                            <th class="p-4 tracking-wider">Kode / QR</th>
                            <th wire:click="sortBy('name')" class="p-4 tracking-wider cursor-pointer hover:bg-gray-100">
                                Nama Suku Cadang
                                @if($sortField === 'name')
                                    <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                @endif
                            </th>
                            <th class="p-4 tracking-wider">Kategori</th>
                            <th wire:click="sortBy('capital_price')" class="p-4 tracking-wider cursor-pointer hover:bg-gray-100">
                                Modal (HPP)
                                @if($sortField === 'capital_price')
                                    <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('price')" class="p-4 tracking-wider cursor-pointer hover:bg-gray-100">
                                Harga Jual
                                @if($sortField === 'price')
                                    <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                @endif
                            </th>
                            <th class="p-4 tracking-wider">Margin Laba</th>
                            <th wire:click="sortBy('stock')" class="p-4 tracking-wider cursor-pointer hover:bg-gray-100">
                                Sisa Stok
                                @if($sortField === 'stock')
                                    <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                @endif
                            </th>
                            <th class="p-4 tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($parts as $part)
                            <tr class="hover:bg-indigo-50/50 transition">
                                <td class="p-4">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-mono text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 px-2 py-0.5 rounded">
                                            {{ $part->item_code }}
                                        </span>
                                        <button wire:click="showQrModal({{ $part->id }})" title="Lihat & Cetak Label QR" class="text-xs bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 p-1.5 rounded transition border border-gray-200 flex items-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="p-4 text-sm font-medium text-gray-900">{{ $part->name }}</td>
                                <td class="p-4 text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                        {{ $part->type->name ?? $part->type }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm font-mono text-gray-500">Rp {{ number_format($part->capital_price, 0, ',', '.') }}</td>
                                <td class="p-4 text-sm font-mono text-gray-900 font-semibold">Rp {{ number_format($part->price, 0, ',', '.') }}</td>
                                <td class="p-4 text-sm font-mono font-bold text-emerald-600">Rp {{ number_format($part->price - $part->capital_price, 0, ',', '.') }}</td>
                                <td class="p-4 text-sm">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold {{ $part->stock > 5 ? 'bg-green-100 text-green-800' : ($part->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ $part->stock }} pcs
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-right space-x-2 whitespace-nowrap">
                                    <button wire:click="showQrModal({{ $part->id }})" class="text-gray-600 hover:text-gray-900 font-semibold text-xs uppercase border border-gray-300 px-2 py-1 rounded hover:bg-gray-100">QR Label</button>
                                    <button wire:click="edit({{ $part->id }})" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs uppercase border border-indigo-200 px-2 py-1 rounded hover:bg-indigo-50">Edit</button>
                                    <button wire:confirm="Yakin ingin menghapus sparepart ini?" wire:click="delete({{ $part->id }})" class="text-red-600 hover:text-red-900 font-semibold text-xs uppercase border border-red-200 px-2 py-1 rounded hover:bg-red-50">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-500 italic">Tidak ada sparepart yang sesuai filter atau pencarian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $parts->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah/Edit -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="store">
                        <div class="bg-white px-6 pt-6 pb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4" id="modal-title">
                                {{ $partId ? 'Edit Spare Part' : 'Tambah Spare Part Baru' }}
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Kode / SKU Part (Opsional)</label>
                                    <input type="text" wire:model="code" placeholder="Contoh: SP-1001 (Otomatis jika kosong)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono">
                                    <p class="text-[11px] text-gray-400 mt-0.5">Kode unik yang digunakan untuk QR Code label dan barcode scanner.</p>
                                    @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Nama Suku Cadang *</label>
                                    <input type="text" wire:model="name" placeholder="Contoh: LCD iPhone 11 Original" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Kategori / Tipe *</label>
                                    <select wire:model="spare_part_type_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('spare_part_type_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Modal / HPP (Rp) *</label>
                                        <input type="number" wire:model="capital_price" placeholder="Harga Modal Toko" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono">
                                        @error('capital_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Harga Jual (Rp) *</label>
                                        <input type="number" wire:model="price" placeholder="Harga Tagihan" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono">
                                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Stok Fisik *</label>
                                    <input type="number" wire:model="stock" placeholder="0" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 flex justify-end gap-2 border-t border-gray-100">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-md shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                                Simpan Spare Part
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal QR Code Label & Print Preview -->
    @if($isQrModalOpen && $selectedPartForQr)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="qr-modal-title" role="dialog" aria-modal="true" x-data x-init="$nextTick(() => {
            if (window.QRCode && document.getElementById('qrCodeContainer')) {
                document.getElementById('qrCodeContainer').innerHTML = '';
                new QRCode(document.getElementById('qrCodeContainer'), {
                    text: 'COREFIX:PART:{{ $selectedPartForQr->item_code }}',
                    width: 130,
                    height: 130,
                    colorDark: '#000000',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
            }
        })">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeQrModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center text-white">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            <h3 class="font-bold text-base">QR Code Label Suku Cadang</h3>
                        </div>
                        <button wire:click="closeQrModal" class="text-white hover:text-gray-200 text-xl font-bold">&times;</button>
                    </div>

                    <div class="p-6">
                        <!-- Printable Label Card Container -->
                        <div id="printableQrLabel" class="bg-white border-2 border-dashed border-gray-300 p-5 rounded-xl text-center shadow-inner">
                            <div class="text-xs font-extrabold uppercase tracking-widest text-primary mb-1">COREFIX SERVICE</div>
                            <div class="text-[10px] text-gray-400 mb-3">{{ $selectedPartForQr->type->name ?? $selectedPartForQr->type }}</div>
                            
                            <div class="flex justify-center my-3">
                                <div id="qrCodeContainer" class="p-2 bg-white rounded-lg border border-gray-200 shadow-sm inline-block"></div>
                            </div>

                            <div class="font-mono text-sm font-extrabold text-gray-900 bg-gray-100 inline-block px-3 py-1 rounded border border-gray-300 mb-2">
                                {{ $selectedPartForQr->item_code }}
                            </div>

                            <div class="font-bold text-gray-800 text-sm line-clamp-2">
                                {{ $selectedPartForQr->name }}
                            </div>

                            <div class="mt-2 text-indigo-700 font-mono font-extrabold text-base">
                                Rp {{ number_format($selectedPartForQr->price, 0, ',', '.') }}
                            </div>
                            <div class="text-[10px] text-gray-400 mt-1">Stok: {{ $selectedPartForQr->stock }} pcs</div>
                        </div>

                        <p class="text-xs text-gray-500 text-center mt-4">
                            Stempel atau tempelkan QR ini pada kemasan / laci sparepart. Teknisi dapat langsung scan menggunakan kamera atau barcode scanner pada saat pengerjaan tiket order.
                        </p>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-100">
                        <button type="button" wire:click="closeQrModal" class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Tutup
                        </button>
                        <button type="button" onclick="window.print()" class="px-5 py-2 rounded-md shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Stiker Label
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

