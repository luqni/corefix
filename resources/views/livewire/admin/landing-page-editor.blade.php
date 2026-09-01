<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center sm:justify-between mb-8 pb-4 border-b border-gray-200">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Konten Landing Page</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola teks banner, voucher promo, profil usaha, dan kontak yang tampil di halaman depan website.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex-none">
            <button wire:click="save" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none transition">
                <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6 text-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="space-y-8">
        <!-- Hero Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-900">Bagian Banner Utama (Hero Section)</h3>
                <p class="mt-1 text-xs text-gray-500">Teks pembuka pertama yang dilihat pengunjung saat membuka website.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Judul Bagian 1</label>
                        <input type="text" wire:model="state.hero_title_1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Judul Bagian 2 (Warna Aksen/Sorot)</label>
                        <input type="text" wire:model="state.hero_title_2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Judul Bagian 3</label>
                        <input type="text" wire:model="state.hero_title_3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Sub-judul / Penjelasan Singkat Layanan</label>
                        <textarea wire:model="state.hero_subtitle" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Teks Tombol Aksi (CTA)</label>
                        <input type="text" wire:model="state.hero_cta_text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Link Tombol Aksi (CTA Link)</label>
                        <input type="text" wire:model="state.hero_cta_link" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Promo Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-900">Bagian Promo & Kupon Diskon</h3>
                <p class="mt-1 text-xs text-gray-500">Penawaran diskon spesial untuk menarik minat calon pelanggan.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Judul Promo</label>
                        <input type="text" wire:model="state.promo_title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Kode Promo / Kupon</label>
                        <input type="text" wire:model="state.promo_code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-mono">
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Deskripsi Promo (Mendukung HTML)</label>
                        <textarea wire:model="state.promo_text" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Catatan / Syarat Ketentuan Promo</label>
                        <input type="text" wire:model="state.promo_note" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Teks Tombol Promo</label>
                        <input type="text" wire:model="state.promo_cta_text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Link Tombol Promo</label>
                        <input type="text" wire:model="state.promo_cta_link" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- About Us Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-900">Bagian Tentang Kami (Profil Usaha)</h3>
                <p class="mt-1 text-xs text-gray-500">Informasi kredibilitas, keahlian, dan statistik pencapaian usaha Anda.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Judul Bagian Profil</label>
                        <input type="text" wire:model="state.about_title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Sub-judul</label>
                        <input type="text" wire:model="state.about_subtitle" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Paragraf Konten 1</label>
                        <textarea wire:model="state.about_content_1" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Paragraf Konten 2</label>
                        <textarea wire:model="state.about_content_2" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    
                    <!-- Stats -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Tahun Pengalaman</label>
                        <input type="text" wire:model="state.about_exp_years" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: 5+">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Jumlah Perangkat Ditangani</label>
                        <input type="text" wire:model="state.about_devices_count" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: 10k+">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Tingkat Kepuasan (%)</label>
                        <input type="text" wire:model="state.about_satisfaction_percent" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Contoh: 99%">
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-900">Bagian Ajakan Servis Bawah (Bottom CTA)</h3>
                <p class="mt-1 text-xs text-gray-500">Ajakan terakhir sebelum footer untuk mendorong pelanggan konsultasi servis.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Judul Ajakan (CTA)</label>
                        <input type="text" wire:model="state.cta_title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Sub-judul / Keterangan</label>
                        <textarea wire:model="state.cta_subtitle" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Teks Tombol Aksi</label>
                        <input type="text" wire:model="state.cta_button_text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-900">Bagian Footer & Kontak Workshop</h3>
                <p class="mt-1 text-xs text-gray-500">Informasi alamat fisik toko, telepon, dan media sosial yang tampil di bagian bawah setiap halaman.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Deskripsi Singkat Toko di Footer</label>
                        <textarea wire:model="state.footer_description" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Alamat Lengkap Workshop / Toko</label>
                        <textarea wire:model="state.footer_address" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Nomor Telepon / WhatsApp</label>
                        <input type="text" wire:model="state.footer_telephone" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Link Akun Instagram</label>
                        <input type="text" wire:model="state.footer_instagram" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-700 mb-1">Link Akun Facebook</label>
                        <input type="text" wire:model="state.footer_facebook" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-8 flex justify-end">
        <button wire:click="save" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none transition">
            <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
            <span wire:loading wire:target="save">Menyimpan...</span>
        </button>
    </div>
</div>
