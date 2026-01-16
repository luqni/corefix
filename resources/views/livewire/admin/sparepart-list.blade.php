<div>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <!-- Header & Actions -->
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Spare Parts Inventory</h3>
                <button wire:click="create" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-medium">
                    + Add New Part
                </button>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 shadow mb-6 relative">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-left border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-50 uppercase text-xs font-bold text-gray-500 border-b">
                            <th class="p-4 tracking-wider">Item Name</th>
                            <th class="p-4 tracking-wider">Type / Category</th>
                            <th class="p-4 tracking-wider">Price (IDR)</th>
                            <th class="p-4 tracking-wider">Stock</th>
                            <th class="p-4 tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($parts as $part)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-4 text-sm font-medium text-gray-900">{{ $part->name }}</td>
                                <td class="p-4 text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $part->type }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm font-mono text-gray-700">Rp {{ number_format($part->price, 0, ',', '.') }}</td>
                                <td class="p-4 text-sm">
                                    <span class="{{ $part->stock > 0 ? 'text-green-600' : 'text-red-600 font-bold' }}">
                                        {{ $part->stock }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-right space-x-2">
                                    <button wire:click="edit({{ $part->id }})" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase">Edit</button>
                                    <button wire:confirm="Are you sure you want to delete this item?" wire:click="delete({{ $part->id }})" class="text-red-600 hover:text-red-900 font-bold text-xs uppercase">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500 italic">No spare parts found. Start by adding one.</td>
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

    <!-- Modal Overlay -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    {{ $partId ? 'Edit Spare Part' : 'Add New Spare Part' }}
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Item Name</label>
                                        <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Type / Category</label>
                                        <select wire:model="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Select Type</option>
                                            <option value="LCD">LCD / Screen</option>
                                            <option value="Battery">Battery</option>
                                            <option value="Charging Port">Charging Port</option>
                                            <option value="Camera">Camera</option>
                                            <option value="Housing">Housing / Casing</option>
                                            <option value="Logic Board">IC / Logic Board</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Price (IDR)</label>
                                            <input type="number" wire:model="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Stock View</label>
                                            <input type="number" wire:model="stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="save" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
