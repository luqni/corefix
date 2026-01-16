<div class="max-w-3xl mx-auto py-8 px-4">
    
    <!-- Search Box -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h1 class="text-2xl font-bold mb-4">Track Your Repair</h1>
        <form wire:submit.prevent="trackTicket" class="flex gap-4">
            <input type="text" wire:model="ticketId" placeholder="Enter Ticket Number (UUID)" class="flex-grow border p-2 rounded">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-semibold hover:bg-indigo-700">Track</button>
        </form>
        @error('ticketId') <p class="text-red-500 mt-2">{{ $message }}</p> @enderror
    </div>

    @if($ticket)
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-start mb-6 border-b pb-4">
                <div>
                    <h2 class="text-xl font-bold">Ticket #{{ substr($ticket->id, 0, 8) }}...</h2>
                    <p class="text-gray-600">{{ $ticket->device_model }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold capitalize 
                        {{ $ticket->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ str_replace('_', ' ', $ticket->status) }}
                    </span>
                    <p class="text-sm text-gray-500 mt-1">{{ $ticket->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Timeline -->
            <div class="mb-8">
                <h3 class="font-bold text-gray-800 mb-4">Status History</h3>
                <div class="border-l-4 border-indigo-200 ml-2 space-y-6">
                    @foreach($ticket->logs->sortByDesc('created_at') as $log)
                        <div class="relative pl-6">
                            <div class="absolute -left-2.5 top-1 h-4 w-4 rounded-full bg-indigo-600 border-2 border-white"></div>
                            <p class="text-sm text-gray-500">{{ $log->created_at->format('d M Y, H:i') }}</p>
                            <p class="font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $log->new_status) }}</p>
                            @if($log->notes)
                                <p class="text-gray-600 text-sm mt-1">{{ $log->notes }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Section -->
            @if($ticket->total_cost && $ticket->payment_status === 'unpaid')
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-2">Payment Required</h3>
                    <p class="mb-4">Total Cost: <span class="font-bold text-indigo-600">Rp {{ number_format($ticket->total_cost, 0, ',', '.') }}</span></p>
                    
                    <p class="text-sm text-gray-600 mb-4">Please transfer to BCA 1234567890 a.n Corefix and upload proof below.</p>

                    @if($isUploaded)
                        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                            Payment proof uploaded successfully! Waiting for verification.
                        </div>
                    @else
                        <form wire:submit.prevent="uploadProof">
                            <input type="file" wire:model="paymentProof" class="block w-full text-sm text-gray-900 border border-gray-300 rounded cursor-pointer mb-2 bg-gray-50">
                            @error('paymentProof') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            
                            <button type="submit" class="mt-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                                wire:loading.attr="disabled" wire:target="uploadProof">
                                <span wire:loading wire:target="uploadProof">Uploading...</span>
                                <span wire:loading.remove wire:target="uploadProof">Upload Proof</span>
                            </button>
                        </form>
                    @endif
                </div>
            @elseif($ticket->payment_status === 'waiting_verification')
                <div class="bg-yellow-50 p-4 rounded text-yellow-800">
                    <strong>Payment under verification.</strong> We are checking your payment proof.
                </div>
            @elseif($ticket->payment_status === 'paid')
                <div class="bg-green-50 p-4 rounded text-green-800">
                    <strong>Paid.</strong> Thank you! Your payment has been verified.
                </div>
            @endif
        </div>
    @elseif($ticketId)
        <div class="text-center py-8 text-gray-500">
            No ticket found with ID: {{ $ticketId }}
        </div>
    @endif
</div>
