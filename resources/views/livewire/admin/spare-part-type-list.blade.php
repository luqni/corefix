<div class="p-6 bg-white border-b border-gray-200">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">{{ $title ?? 'Kategori Suku Cadang' }}</h2>
        <div class="flex items-center space-x-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama kategori..." class="shadow appearance-none border rounded w-64 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm">
            <button wire:click="create()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm shadow-sm">
                + Tambah Kategori Baru
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                    <th class="py-3 px-6 text-left">No</th>
                    <th wire:click="sortBy('name')" class="py-3 px-6 text-left cursor-pointer hover:bg-gray-200">
                        Nama Kategori
                        @if($sortField === 'name')
                            <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                        @endif
                    </th>
                    <th wire:click="sortBy('slug')" class="py-3 px-6 text-left cursor-pointer hover:bg-gray-200">
                        Slug URL
                        @if($sortField === 'slug')
                            <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                        @endif
                    </th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($types as $type)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left font-medium text-gray-900">{{ $type->name }}</td>
                        <td class="py-3 px-6 text-left font-mono text-xs text-gray-500">{{ $type->slug }}</td>
                        <td class="py-3 px-6 text-center">
                            <button wire:click="edit({{ $type->id }})" class="text-blue-600 hover:text-blue-800 font-semibold mr-3">Edit</button>
                            <button wire:click="delete({{ $type->id }})" class="text-red-600 hover:text-red-800 font-semibold" onclick="confirm('Yakin ingin menghapus kategori ini?') || event.stopImmediatePropagation()">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $types->links() }}
    </div>

    <!-- Modal -->
    @if($isModalOpen)
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori Suku Cadang:</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm" id="name" wire:model="name" placeholder="Contoh: LCD Screen, Baterai, IC...">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto">
                            Simpan Kategori
                        </button>
                        <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
