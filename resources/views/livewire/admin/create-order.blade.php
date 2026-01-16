<div>
    <div class="max-w-3xl mx-auto bg-white shadow sm:rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-indigo-600 border-b border-indigo-500 flex justify-between items-center">
            <h3 class="text-lg leading-6 font-medium text-white">New Order Entry</h3>
            <a href="{{ route('admin.orders') }}" class="text-indigo-100 hover:text-white text-sm font-medium">&larr; Cancel</a>
        </div>
        
        <div class="p-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Customer Details -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Customer Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                            <input wire:model="name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g. Budi Santoso">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                            <input wire:model="whatsapp" type="text" id="whatsapp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g. 08123456789">
                            @error('whatsapp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address / Location</label>
                            <textarea wire:model="address" id="address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Full address for home service"></textarea>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Device Details -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b border-gray-200 pb-2">Device & Issue</h4>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="device" class="block text-sm font-medium text-gray-700">Device Model</label>
                            <input wire:model="device" type="text" id="device" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g. iPhone 11 Pro">
                            @error('device') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="issue" class="block text-sm font-medium text-gray-700">Problem Description</label>
                            <textarea wire:model="issue" id="issue" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Describe the issue..."></textarea>
                            @error('issue') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
