<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Kelola Kupon Promo</h2>
                        <p class="text-xs text-gray-500">Buat dan atur voucher diskon untuk servis dan pembelian sparepart pelanggan.</p>
                    </div>
                    <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm shadow-sm">
                        + Buat Kupon Baru
                    </button>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3 text-left">Kode Kupon</th>
                                <th class="px-6 py-3 text-left">Tipe Diskon</th>
                                <th class="px-6 py-3 text-left">Nilai Potongan</th>
                                <th class="px-6 py-3 text-left">Batas Pakai</th>
                                <th class="px-6 py-3 text-left">Jumlah Terpakai</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-indigo-700">{{ $coupon->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->type === 'fixed' ? 'Nominal Tetap (Rp)' : 'Persentase (%)' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-mono font-semibold text-gray-900">
                                        {{ $coupon->type == 'fixed' ? 'Rp ' . number_format($coupon->value, 0, ',', '.') : $coupon->value . '%' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->max_uses ? $coupon->max_uses . ' kali' : 'Tanpa Batas' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->used_count }} kali</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full {{ $coupon->is_active && $coupon->isValid() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $coupon->is_active && $coupon->isValid() ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                        <button wire:click="edit({{ $coupon->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">Edit</button>
                                        <button wire:click="delete({{ $coupon->id }})" class="text-red-600 hover:text-red-900 font-semibold" onclick="return confirm('Yakin ingin menghapus kupon ini?') || event.stopImmediatePropagation()">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400 italic">Belum ada kupon promo yang dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                    {{ $couponId ? 'Edit Kupon Promo' : 'Buat Kupon Promo Baru' }}
                                </h3>
                                <div class="mt-4 grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Kode Kupon *</label>
                                        <input type="text" wire:model="code" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm uppercase font-mono" placeholder="Contoh: HEMAT20, DISKON50">
                                        @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Tipe Diskon *</label>
                                            <select wire:model="type" class="block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                <option value="fixed">Nominal Tetap (Rp)</option>
                                                <option value="percentage">Persentase (%)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Nilai Potongan *</label>
                                            <input type="number" wire:model="value" step="0.01" class="block w-full border-gray-300 rounded-md shadow-sm text-sm font-mono" placeholder="10000 atau 10">
                                            @error('value') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Batas Maksimal Penggunaan (Opsional)</label>
                                        <input type="number" wire:model="max_uses" placeholder="Kosongkan jika tanpa batas" class="block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Tanggal Mulai Berlaku</label>
                                            <input type="datetime-local" wire:model="start_date" class="block w-full border-gray-300 rounded-md shadow-sm text-xs">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Tanggal Berakhir</label>
                                            <input type="datetime-local" wire:model="end_date" class="block w-full border-gray-300 rounded-md shadow-sm text-xs">
                                        </div>
                                    </div>
                                    <div class="flex items-center pt-2">
                                        <input type="checkbox" id="is_active_check" wire:model="is_active" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="is_active_check" class="ml-2 block text-sm font-semibold text-gray-900 cursor-pointer">Kupon Aktif & Bisa Digunakan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end gap-2 border-t border-gray-100">
                        <button wire:click="closeModal" type="button" class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Batal
                        </button>
                        <button wire:click="store" type="button" class="px-4 py-2 rounded-md shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                            Simpan Kupon
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
