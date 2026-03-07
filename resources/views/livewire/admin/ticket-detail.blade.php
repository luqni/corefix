<div>
    <div class="flex justify-between items-center mb-6">
        <div>
           <span class="text-sm text-gray-400 uppercase font-bold tracking-wide">Ticket ID</span>
           <h2 class="text-3xl font-black text-gray-800 tracking-tight">{{ substr($ticket->id, 0, 8) }}</h2>
        </div>
        <a href="{{ route('admin.orders') }}" class="text-gray-500 hover:text-gray-900 border px-3 py-2 rounded-md transition text-sm font-medium">&larr; Back to Orders</a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 shadow mb-6 relative">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT COLUMN: Ticket Info & Logs -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Device & Customer Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Customer & Device Details</h3>
                    <div class="flex space-x-2">
                        @if(auth()->user()->hasRole(['super_admin', 'admin']) && !$isEditingCustomer)
                        <button wire:click="editCustomerData" class="text-xs text-indigo-600 border border-indigo-200 bg-white px-3 py-1 rounded font-bold uppercase tracking-wide hover:bg-indigo-50 transition">
                            ✏️ Edit
                        </button>
                        @endif
                        <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-1 rounded font-bold uppercase tracking-wide">Info</span>
                    </div>
                </div>
                <div class="p-6">
                    @if($isEditingCustomer)
                    <form wire:submit.prevent="saveCustomerData" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Device Model</label>
                            <input type="text" wire:model="editDeviceModel" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Customer Name</label>
                            <input type="text" wire:model="editCustomerName" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Reported Issue</label>
                            <input type="text" wire:model="editIssue" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">WhatsApp</label>
                            <input type="text" wire:model="editCustomerWa" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Address</label>
                            <textarea wire:model="editCustomerAddress" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"></textarea>
                        </div>
                        <div class="md:col-span-2 flex justify-end space-x-2 mt-2">
                            <button type="button" wire:click="$set('isEditingCustomer', false)" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">Cancel</button>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">Save Changes</button>
                        </div>
                    </form>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Device Model</label>
                            <p class="font-bold text-lg text-gray-800">{{ $ticket->device_model }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Reported Issue</label>
                            <p class="text-gray-700">{{ $ticket->issue_description }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Customer Name</label>
                            <p class="font-semibold text-gray-800">{{ $ticket->customer_name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">WhatsApp</label>
                            <p class="text-gray-600 font-mono">{{ $ticket->customer_wa }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Address</label>
                            <p class="text-gray-600">{{ $ticket->customer_address }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Activity Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @foreach($ticket->logs->sortByDesc('created_at') as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Status changed to <span class="font-bold text-gray-900 uppercase">{{ str_replace('_', ' ', $log->new_status) }}</span></p>
                                                @if($log->notes)
                                                    <div class="mt-2 text-sm text-gray-600 bg-gray-50 p-2 rounded border border-gray-100 italic">"{{ $log->notes }}"</div>
                                                @endif
                                            </div>
                                            <div class="text-right text-xs whitespace-nowrap text-gray-400">
                                                <time datetime="{{ $log->created_at }}">{{ $log->created_at->format('d M H:i') }}</time>
                                                <div class="mt-1 font-medium text-gray-500">{{ $log->user ? explode(' ', $log->user->name)[0] : 'System' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Actions -->
        <div class="space-y-8">
            
            <!-- Status Update Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="font-bold text-white">Update Status</h3>
                </div>
                <div class="p-6">
                    <form wire:submit.prevent="updateStatus">
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">New Status</label>
                            <select wire:model="newStatus" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="pending">Pending</option>
                                <option value="received">Unit Received</option>
                                <option value="diagnosing">Diagnosing</option>
                                <option value="waiting_approval">Waiting Approval</option>
                                <option value="repairing">Repairing</option>
                                <option value="payment_verification">Payment Verification</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Internal Note / Customer Msg</label>
                            <textarea wire:model="note" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Add a note..."></textarea>
                        </div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Ticket Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Invoice Items & Payment -->
            @if(auth()->user()->hasRole(['super_admin', 'admin']))
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-800 px-6 py-4 flex justify-between items-center gap-2 overflow-x-auto">
                    <h3 class="font-bold text-white whitespace-nowrap">Invoice Items</h3>
                    <div class="flex flex-shrink-0 items-center gap-2">
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $ticket->customer_wa);
                            if (str_starts_with($waNumber, '0')) {
                                $waNumber = '62' . substr($waNumber, 1);
                            }
                            $statusText = strtoupper(str_replace('_', ' ', $ticket->payment_status));
                            $formattedTotal = number_format($ticket->total_cost, 0, ',', '.');
                            $detailLink = route('tracking', $ticket->id);
                            
                            $waText = "Halo *{$ticket->customer_name}*, berikut adalah nota/invoice perbaikan *{$ticket->device_model}* Anda di CoreFix Service.\n\nTotal Tagihan: *Rp {$formattedTotal}*\nStatus Pembayaran: *{$statusText}*\n\nTerlampir juga file PDF Invoice Anda.\n\nDetail lengkap dapat dilihat pada tautan berikut:\n{$detailLink}\n\nTerima kasih atas kepercayaannya.";
                            $waUrl = "https://wa.me/{$waNumber}?text=".urlencode($waText);
                            $pdfUrl = route('admin.tickets.invoice.pdf', $ticket->id);
                        @endphp
                        
                        <a href="javascript:void(0)" 
                           onclick="window.open('{{ $waUrl }}', '_blank'); window.location.href='{{ $pdfUrl }}';"
                           class="text-xs bg-[#25D366] text-white px-3 py-1.5 rounded hover:bg-[#1da851] transition font-bold uppercase flex items-center whitespace-nowrap">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.06-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            Kirim WA & PDF
                        </a>
                        <a href="{{ route('admin.tickets.invoice', $ticket->id) }}" target="_blank" class="text-xs bg-white text-gray-800 px-3 py-1.5 rounded hover:bg-gray-200 transition font-bold uppercase flex items-center whitespace-nowrap">
                            🖨️ Print
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Item List -->
                    <div class="mb-6">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                                <tr>
                                    <th class="px-2 py-2">Item</th>
                                    <th class="px-2 py-2 w-16">Qty</th>
                                    <th class="px-2 py-2 w-24 text-right">Price</th>
                                    <th class="px-2 py-2 w-24 text-right">Total</th>
                                    <th class="px-2 py-2 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($ticket->items as $item)
                                    <tr>
                                        <td class="px-2 py-2">{{ $item->description }}</td>
                                        <td class="px-2 py-2 text-center">{{ $item->quantity }}</td>
                                        <td class="px-2 py-2 text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-2 py-2 text-right font-medium">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                        <td class="px-2 py-2 text-right">
                                            <button wire:click="removeItem({{ $item->id }})" class="text-red-400 hover:text-red-600">
                                                &times;
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-2 py-4 text-center text-gray-400 italic">No items added yet.</td>
                                    </tr>
                                @endforelse

                                @if($ticket->discount_amount > 0)
                                    <tr class="text-gray-600">
                                        <td colspan="3" class="px-2 py-2 text-right">Subtotal</td>
                                        <td class="px-2 py-2 text-right">{{ number_format($ticket->subtotal, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                    <tr class="text-green-600">
                                        <td colspan="3" class="px-2 py-2 text-right">
                                            Discount <span class="text-xs bg-green-100 text-green-800 px-1 rounded uppercase">{{ $ticket->coupon_code }}</span>
                                        </td>
                                        <td class="px-2 py-2 text-right">- {{ number_format($ticket->discount_amount, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                @endif

                                <tr class="bg-gray-50 font-bold text-gray-800">
                                    <td colspan="3" class="px-2 py-3 text-right">TOTAL</td>
                                    <td class="px-2 py-3 text-right">{{ number_format($ticket->total_cost, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Item Form -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">Add Item / Spare Part</h4>
                        <div class="grid grid-cols-1 gap-3">
                            <select wire:model.live="selectedPartId" class="block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <option value="">-- Select from Inventory (Optional) --</option>
                                @foreach($spareParts as $part)
                                    <option value="{{ $part->id }}">{{ $part->name }} (Rp {{ number_format($part->price, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                            
                            <div class="flex gap-2 items-center">
                                <input type="text" wire:model="newItemDescription" placeholder="Item Description (e.g. Service Fee)" class="block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <button type="button" wire:click="$set('newItemDescription', 'Biaya Jasa Perbaikan')" class="text-xs text-indigo-600 hover:text-indigo-800 underline whitespace-nowrap">
                                    + Jasa Service
                                </button>
                            </div>
                            
                            <div class="flex gap-2">
                                <div class="w-1/3">
                                    <input type="number" wire:model="newItemPrice" placeholder="Price" class="block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                                <div class="w-1/4">
                                     <input type="number" wire:model="newItemQty" placeholder="Qty" class="block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                                <button wire:click="addItem" class="flex-1 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">Add</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Status & Verification -->
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-medium text-gray-500">Payment Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium uppercase
                                {{ match($ticket->payment_status) {
                                    'paid' => 'bg-green-100 text-green-800',
                                    'unpaid' => 'bg-red-100 text-red-800',
                                    'waiting_verification' => 'bg-yellow-100 text-yellow-800',
                                } }}">
                                {{ str_replace('_', ' ', $ticket->payment_status) }}
                            </span>
                        </div>

                        @if($ticket->payment_proof)
                            <div class="space-y-3">
                                <p class="text-xs uppercase font-bold text-gray-500">Uploaded Proof</p>
                                <a href="{{ Storage::url($ticket->payment_proof) }}" target="_blank" class="block group relative rounded-lg overflow-hidden border border-gray-200">
                                    <img src="{{ Storage::url($ticket->payment_proof) }}" class="w-full h-32 object-cover group-hover:opacity-75 transition">
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">View Full Image</span>
                                    </div>
                                </a>
                                
                                @if($ticket->payment_status !== 'paid')
                                    <button wire:click="approvePayment" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none transition">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Verify & Approve Payment
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-1 text-xs text-gray-500">No payment proof uploaded yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
