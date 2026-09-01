<div>
    <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-indigo-600 border-b border-indigo-500 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-bold text-white">Input Pesanan Servis Baru</h3>
            <a href="{{ route('admin.orders') }}" class="text-indigo-100 hover:text-white text-sm font-medium">&larr; Kembali / Batal</a>
        </div>
        
        <div class="p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Customer Details -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Informasi Pelanggan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-xs font-bold uppercase text-gray-700 mb-1">Nama Pelanggan *</label>
                            <input wire:model="name" type="text" id="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: Budi Santoso">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="whatsapp" class="block text-xs font-bold uppercase text-gray-700 mb-1">Nomor WhatsApp *</label>
                            <input wire:model="whatsapp" type="text" id="whatsapp" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-mono" placeholder="Contoh: 08123456789">
                            @error('whatsapp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-xs font-bold uppercase text-gray-700 mb-1">Alamat Lengkap / Lokasi Unit</label>
                            <textarea wire:model="address" id="address" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Alamat pelanggan untuk home service atau pengiriman"></textarea>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Device Details -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Informasi Perangkat & Kerusakan</h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="device" class="block text-xs font-bold uppercase text-gray-700 mb-1">Tipe / Model Perangkat *</label>
                            <input wire:model="device" type="text" id="device" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: iPhone 11 Pro, MacBook Air M1, Samsung S21">
                            @error('device') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="issue" class="block text-xs font-bold uppercase text-gray-700 mb-1">Deskripsi Kerusakan / Keluhan *</label>
                            <textarea wire:model="issue" id="issue" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Jelaskan kondisi kerusakan perangkat secara rinci..."></textarea>
                            @error('issue') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-semibold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        Buat & Simpan Pesanan Servis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
