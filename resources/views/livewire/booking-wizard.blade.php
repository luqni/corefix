<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="mb-4">
        <!-- Progress Bar -->
        <div class="flex justify-between mb-4">
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded {{ $step >= 1 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 bg-gray-200' }}">
                1. Device Info
            </span>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded {{ $step >= 2 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 bg-gray-200' }}">
                2. Service Type
            </span>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded {{ $step >= 3 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 bg-gray-200' }}">
                3. Customer Info
            </span>
        </div>
    </div>

    <form wire:submit.prevent="submit">
        
        <!-- Step 1: Device Info -->
        @if($step === 1)
            <div>
                <h2 class="text-xl font-bold mb-4">Device Information</h2>
                <div class="mb-4">
                    <label class="block text-gray-700">Brand</label>
                    <input type="text" wire:model="brand" class="w-full border p-2 rounded">
                    @error('brand') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Model</label>
                    <input type="text" wire:model="model" class="w-full border p-2 rounded">
                    @error('model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Issue Description</label>
                    <textarea wire:model="issue" class="w-full border p-2 rounded"></textarea>
                    @error('issue') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        <!-- Step 2: Service Type -->
        @if($step === 2)
            <div>
                <h2 class="text-xl font-bold mb-4">Service Type</h2>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Select Service Mode</label>
                    <div class="flex gap-4">
                        <label class="border p-4 rounded w-full cursor-pointer {{ $service_type === 'walk-in' ? 'bg-indigo-50 border-indigo-500' : '' }}">
                            <input type="radio" wire:model="service_type" value="walk-in" class="mr-2">
                            Walk-in (Visit Counter)
                        </label>
                        <label class="border p-4 rounded w-full cursor-pointer {{ $service_type === 'pickup' ? 'bg-indigo-50 border-indigo-500' : '' }}">
                            <input type="radio" wire:model="service_type" value="pickup" class="mr-2">
                            Pickup / Delivery
                        </label>
                    </div>
                    @error('service_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        <!-- Step 3: Customer Info -->
        @if($step === 3)
            <div>
                <h2 class="text-xl font-bold mb-4">Customer Information</h2>
                <div class="mb-4">
                    <label class="block text-gray-700">Full Name</label>
                    <input type="text" wire:model="name" class="w-full border p-2 rounded">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">WhatsApp Number</label>
                    <input type="text" wire:model="whatsapp" class="w-full border p-2 rounded">
                    @error('whatsapp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Address</label>
                    <textarea wire:model="address" class="w-full border p-2 rounded"></textarea>
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-6">
            @if($step > 1)
                <button type="button" wire:click="prevStep" class="bg-gray-500 text-white px-4 py-2 rounded">Back</button>
            @else
                <div></div>
            @endif

            @if($step < 3)
                <button type="button" wire:click="nextStep" class="bg-blue-600 text-white px-4 py-2 rounded">Next</button>
            @else
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Submit Order</button>
            @endif
        </div>

    </form>
</div>
