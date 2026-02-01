<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Manage Coupons</h2>
                    <button wire:click="create" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Coupon
                    </button>
                </div>

                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max Uses</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $coupon->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $coupon->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $coupon->type == 'fixed' ? 'Rp ' . number_format($coupon->value, 0, ',', '.') : $coupon->value . '%' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->max_uses ?? 'Unlimited' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $coupon->used_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $coupon->is_active && $coupon->isValid() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $coupon->is_active && $coupon->isValid() ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="edit({{ $coupon->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                        <button wire:click="delete({{ $coupon->id }})" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
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
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    {{ $couponId ? 'Edit Coupon' : 'Create Coupon' }}
                                </h3>
                                <div class="mt-4 grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Code</label>
                                        <input type="text" wire:model="code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="e.g. SAVE20">
                                        @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Type</label>
                                            <select wire:model="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                <option value="fixed">Fixed Amount</option>
                                                <option value="percentage">Percentage</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Value</label>
                                            <input type="number" wire:model="value" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            @error('value') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Max Uses (Optional)</label>
                                        <input type="number" wire:model="max_uses" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                            <input type="datetime-local" wire:model="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">End Date</label>
                                            <input type="datetime-local" wire:model="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" wire:model="is_active" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label class="ml-2 block text-sm text-gray-900">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
