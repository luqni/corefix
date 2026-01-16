<div>
    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="p-6 text-gray-900">
            
            <!-- Filters & Actions -->
            <div class="mb-6 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-4 rounded-lg">
                <div class="w-full md:w-1/3 mb-4 md:mb-0">
                     <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Filter Status</label>
                    <select wire:model.live="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full block">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="received">Unit Received</option>
                        <option value="diagnosing">Diagnosing</option>
                        <option value="waiting_approval">Waiting Approval</option>
                        <option value="repairing">Repairing</option>
                        <option value="payment_verification">Payment Verification</option>
                        <option value="done">Done</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">
                        {{ $tickets->count() }} of {{ $tickets->total() }} orders
                    </span>
                    <a href="{{ route('admin.orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        New Order
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-left border-collapse bg-white">
                    <thead>
                        <tr class="bg-gray-50 uppercase text-xs font-bold text-gray-500 border-b">
                            <th class="p-4 tracking-wider">Date</th>
                            <th class="p-4 tracking-wider">Ticket ID</th>
                            <th class="p-4 tracking-wider">Customer</th>
                            <th class="p-4 tracking-wider">Device</th>
                            <th class="p-4 tracking-wider">Status</th>
                            <th class="p-4 tracking-wider">Payment</th>
                            <th class="p-4 tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="p-4 text-sm font-medium text-gray-600">{{ $ticket->created_at->format('d M Y') }}</td>
                                <td class="p-4 text-sm font-mono text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <span>{{ substr($ticket->id, 0, 8) }}</span>
                                        <button 
                                            x-data
                                            x-on:click="navigator.clipboard.writeText('{{ route('tracking', $ticket->id) }}'); $el.classList.add('text-green-600'); setTimeout(() => $el.classList.remove('text-green-600'), 1000);"
                                            title="Copy Tracking Link"
                                            class="text-gray-400 hover:text-indigo-600 transition"
                                        >
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="p-4 text-sm">
                                    <div class="font-bold text-gray-800">{{ $ticket->customer_name }}</div>
                                    <div class="text-xs text-gray-400">{{ $ticket->customer_wa }}</div>
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $ticket->device_model }}</td>
                                <td class="p-4">
                                    <span class="inline-block px-2 py-0.5 text-xs font-bold uppercase rounded-md 
                                        {{ match($ticket->status) {
                                            'done' => 'bg-green-100 text-green-700 border border-green-200',
                                            'pending' => 'bg-gray-100 text-gray-600 border border-gray-200',
                                            default => 'bg-indigo-50 text-indigo-700 border border-indigo-200'
                                        } }}">
                                        {{ str_replace('_', ' ', $ticket->status) }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-block px-2 py-0.5 text-xs font-bold uppercase rounded-md 
                                        {{ match($ticket->payment_status) {
                                            'paid' => 'bg-green-100 text-green-700 border border-green-200',
                                            'unpaid' => 'bg-red-50 text-red-600 border border-red-200',
                                            'waiting_verification' => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                                        } }}">
                                        {{ str_replace('_', ' ', $ticket->payment_status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-xs uppercase tracking-wide border border-indigo-200 px-3 py-1 rounded hover:bg-indigo-50 transition">Manage</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500 italic">No orders found matching the criteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tickets->links() }}
            </div>

        </div>
    </div>
</div>
