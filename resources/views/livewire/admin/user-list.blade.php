<div>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="p-6 text-gray-900 border-b border-gray-200">
            
            <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4 mb-6">
                <div class="w-full sm:w-1/2">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama, email, atau hak akses..." class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 block w-full text-sm">
                </div>
                <button wire:click="openModal" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm">
                    + Tambah Pengguna
                </button>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 text-sm" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif
            
            @if (session()->has('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 text-sm" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-left border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 font-bold uppercase text-xs border-b">
                            <th class="p-3.5">Nama</th>
                            <th class="p-3.5">Email</th>
                            <th class="p-3.5">Peran (Role)</th>
                            <th class="p-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3.5 font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="p-3.5 text-gray-600 font-mono text-xs">{{ $user->email }}</td>
                                <td class="p-3.5">
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full 
                                        {{ $user->role === 'super_admin' ? 'bg-red-100 text-red-800' : 
                                           ($user->role === 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800') }}">
                                        {{ match($user->role) {
                                            'super_admin' => 'SUPER ADMIN',
                                            'admin' => 'ADMIN',
                                            'teknisi' => 'TEKNISI',
                                            default => strtoupper($user->role)
                                        } }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-center whitespace-nowrap">
                                    <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-800 mr-3 font-semibold text-xs uppercase border border-indigo-200 px-2.5 py-1 rounded hover:bg-indigo-50">Edit</button>
                                    <button onclick="confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $user->id }})" class="text-red-600 hover:text-red-800 font-semibold text-xs uppercase border border-red-200 px-2.5 py-1 rounded hover:bg-red-50">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-gray-400 italic">Tidak ada data pengguna yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="store">
                        <div class="bg-white px-6 pt-5 pb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b" id="modal-title">
                                {{ $userId ? 'Edit Akun Pengguna' : 'Tambah Pengguna Baru' }}
                            </h3>
                            
                            <div class="mb-4">
                                <label for="name" class="block text-xs font-bold uppercase text-gray-700 mb-1">Nama Lengkap *</label>
                                <input type="text" wire:model="name" id="name" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-gray-300 rounded-md">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-xs font-bold uppercase text-gray-700 mb-1">Alamat Email *</label>
                                <input type="email" wire:model="email" id="email" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-gray-300 rounded-md">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="role" class="block text-xs font-bold uppercase text-gray-700 mb-1">Peran / Hak Akses *</label>
                                <select wire:model="role" id="role" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <option value="super_admin">Super Admin (Akses Penuh)</option>
                                    <option value="admin">Admin Toko</option>
                                    <option value="teknisi">Teknisi Servis</option>
                                </select>
                                @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="block text-xs font-bold uppercase text-gray-700 mb-1">Kata Sandi (Password) {{ $userId ? '(Kosongkan jika tidak ingin diubah)' : '*' }}</label>
                                <input type="password" wire:model="password" id="password" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-gray-300 rounded-md">
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 flex justify-end gap-2 border-t border-gray-100">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-md shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                                Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
