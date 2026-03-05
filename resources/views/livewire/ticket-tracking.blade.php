<div class="bg-gray-50 min-h-screen pb-24">
    <!-- Hero Section -->
    <div class="relative bg-primary text-white py-16 overflow-hidden">
        <div class="absolute inset-0 bg-secondary/10 opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
             <h1 class="text-3xl md:text-4xl font-extrabold mb-4">Lacak Status Service</h1>
             <p class="text-blue-100 text-lg max-w-2xl mx-auto">Pantau perkembangan perbaikan gadget Anda secara real-time dengan memasukkan ID Tiket.</p>
        </div>
        <!-- Decorative blobs -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <!-- Search Box -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <form wire:submit.prevent="trackTicket" class="flex flex-col md:flex-row gap-4">
                <div class="flex-grow">
                    <label for="ticketId" class="sr-only">Nomor Tiket</label>
                    <input type="text" wire:model="ticketId" placeholder="Masukkan ID Tiket (Contoh: 8a7b3c...)" 
                        class="w-full border-gray-300 rounded-xl focus:ring-secondary focus:border-secondary transition shadow-sm py-3 px-4 text-lg">
                </div>
                <button type="submit" class="bg-secondary text-white px-8 py-3 rounded-xl font-bold hover:bg-[#2267BC] transition shadow-lg shadow-secondary/30 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Lacak
                </button>
            </form>
            @error('ticketId') <p class="text-red-500 mt-2 text-sm flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $message }}</p> @enderror
        </div>
    </div>

    @if($ticket)
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header Card -->
                 <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            Tiket #<span class="font-mono text-primary">{{ substr($ticket->id, 0, 8) }}</span>
                        </h2>
                        <p class="text-gray-500 text-sm">{{ $ticket->device_model }} • {{ $ticket->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                         <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold capitalize 
                            {{ $ticket->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ str_replace('_', ' ', $ticket->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <!-- Progress Stats -->
                    <div class="mb-10">
                        <h3 class="font-bold text-gray-900 mb-6">Riwayat Status</h3>
                        <div class="relative border-l-2 border-gray-200 ml-3 space-y-8">
                            @foreach($ticket->logs->sortByDesc('created_at') as $index => $log)
                                <div class="relative pl-8">
                                    <div class="absolute -left-[9px] top-1.5 h-4 w-4 rounded-full border-2 border-white {{ $index === 0 ? 'bg-primary ring-4 ring-blue-50' : 'bg-gray-300' }}"></div>
                                    <p class="text-xs text-gray-400 font-mono mb-1">{{ $log->created_at->format('d M Y, H:i') }}</p>
                                    <p class="font-bold text-gray-800 capitalize text-lg">{{ str_replace('_', ' ', $log->new_status) }}</p>
                                    @if($log->notes)
                                        <div class="mt-2 text-sm text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-100 inline-block">
                                            {{ $log->notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Section -->
                    @if($ticket->total_cost && $ticket->payment_status === 'unpaid')
                        <div class="bg-orange-50 rounded-xl p-6 border border-orange-100">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                                <div>
                                    <h3 class="font-bold text-lg text-orange-900">Menunggu Pembayaran</h3>
                                    <p class="text-orange-700 text-sm">Silakan selesaikan pembayaran untuk mengambil unit.</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 uppercase font-bold">Total Tagihan</p>
                                    <p class="text-2xl font-black text-gray-900">Rp {{ number_format($ticket->total_cost, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg border border-orange-200 mb-6">
                                <p class="text-sm text-gray-600 mb-2 font-medium">Transfer Bank BCA</p>
                                <div class="flex justify-between items-center">
                                    <span class="font-mono text-lg font-bold text-gray-800">1234567890</span>
                                    <button onclick="navigator.clipboard.writeText('1234567890')" class="text-xs text-primary hover:underline">Copy</button>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">a.n Corefix Indonesia</p>
                            </div>

                            @if($isUploaded)
                                <div class="bg-green-100 text-green-700 p-4 rounded-lg flex items-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <div>
                                        <p class="font-bold">Bukti Terupload!</p>
                                        <p class="text-sm">Mohon tunggu verifikasi admin (1x24 jam).</p>
                                    </div>
                                </div>
                            @else
                                <form wire:submit.prevent="uploadProof">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                                    <input type="file" wire:model="paymentProof" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-orange-100 file:text-orange-700
                                        hover:file:bg-orange-200
                                        cursor-pointer bg-white border border-gray-300 rounded-lg
                                    ">
                                    @error('paymentProof') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    
                                    <button type="submit" class="mt-4 w-full bg-green-600 text-white px-4 py-3 rounded-xl font-bold hover:bg-green-700 transition flex justify-center items-center gap-2"
                                        wire:loading.attr="disabled" wire:target="uploadProof">
                                        <span wire:loading wire:target="uploadProof" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></span>
                                        <span wire:loading.remove wire:target="uploadProof">Kirim Bukti Pembayaran</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @elseif($ticket->payment_status === 'waiting_verification')
                         <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 flex items-start gap-4">
                            <div class="bg-blue-100 p-2 rounded-full text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-blue-900">Verifikasi Pembayaran</h3>
                                <p class="text-blue-700">Kami sedang mengecek bukti pembayaran Anda. Harap menunggu konfirmasi selanjutnya.</p>
                            </div>
                        </div>
                    @elseif($ticket->payment_status === 'paid')
                        <div class="bg-green-50 p-6 rounded-xl border border-green-100 flex items-start gap-4">
                            <div class="bg-green-100 p-2 rounded-full text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-green-900">Pembayaran Lunas</h3>
                                <p class="text-green-700">Terima kasih! Pembayaran Anda telah terverifikasi.</p>
                                <p class="text-sm text-green-600 mt-2">Nomor Tiket: <strong>{{ substr($ticket->id, 0, 8) }}</strong></p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @elseif($ticketId)
        <div class="max-w-3xl mx-auto px-4 mt-8 text-center">
            <div class="bg-white p-8 rounded-2xl shadow border border-gray-100">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Tiket Tidak Ditemukan</h3>
                <p class="text-gray-500">Mohon periksa kembali nomor tiket yang Anda masukkan. Pastikan sesuai dengan yang tertera pada bukti booking.</p>
            </div>
        </div>
    @endif
</div>
