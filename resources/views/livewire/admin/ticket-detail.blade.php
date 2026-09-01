<div>
    <div class="flex justify-between items-center mb-6">
        <div>
           <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">ID Tiket Servis</span>
           <h2 class="text-3xl font-black text-gray-800 tracking-tight">{{ substr($ticket->id, 0, 8) }}</h2>
        </div>
        <a href="{{ route('admin.orders') }}" class="text-gray-600 hover:text-gray-900 border border-gray-300 bg-white px-3.5 py-2 rounded-md transition text-xs font-semibold shadow-sm">&larr; Kembali ke Daftar Order</a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 shadow mb-6 relative text-sm rounded-r">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT COLUMN: Ticket Info & Logs -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Device & Customer Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Detail Pelanggan & Perangkat</h3>
                    <div class="flex space-x-2">
                        @if(auth()->user()->hasRole(['super_admin', 'admin']) && !$isEditingCustomer)
                        <button wire:click="editCustomerData" class="text-xs text-indigo-600 border border-indigo-200 bg-white px-3 py-1 rounded font-bold uppercase tracking-wide hover:bg-indigo-50 transition">
                            ✏️ Edit Data
                        </button>
                        @endif
                        <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-1 rounded font-bold uppercase tracking-wide">Info</span>
                    </div>
                </div>
                <div class="p-6">
                    @if($isEditingCustomer)
                    <form wire:submit.prevent="saveCustomerData" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Model / Tipe Perangkat</label>
                            <input type="text" wire:model="editDeviceModel" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Nama Pelanggan</label>
                            <input type="text" wire:model="editCustomerName" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Keluhan / Kerusakan</label>
                            <input type="text" wire:model="editIssue" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">No. WhatsApp</label>
                            <input type="text" wire:model="editCustomerWa" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Alamat Lengkap</label>
                            <textarea wire:model="editCustomerAddress" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"></textarea>
                        </div>
                        <div class="md:col-span-2 flex justify-end space-x-2 mt-2">
                            <button type="button" wire:click="$set('isEditingCustomer', false)" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">Batal</button>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">Simpan Perubahan</button>
                        </div>
                    </form>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Model / Tipe Perangkat</label>
                            <p class="font-bold text-lg text-gray-800">{{ $ticket->device_model }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Keluhan / Kerusakan</label>
                            <p class="text-gray-700">{{ $ticket->issue_description }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Nama Pelanggan</label>
                            <p class="font-semibold text-gray-800">{{ $ticket->customer_name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">No. WhatsApp</label>
                            <p class="text-gray-600 font-mono">{{ $ticket->customer_wa }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs text-gray-400 uppercase font-bold tracking-wide mb-1">Alamat Lengkap</label>
                            <p class="text-gray-600">{{ $ticket->customer_address }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Riwayat Pengerjaan & Catatan</h3>
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
                    <h3 class="font-bold text-white">Perbarui Status Servis</h3>
                    <span class="text-xs font-bold uppercase px-2 py-0.5 rounded {{ match($ticket->status) {
                        'done' => 'bg-green-500 text-white',
                        'cancelled' => 'bg-red-500 text-white',
                        'refunded' => 'bg-purple-500 text-white',
                        default => 'bg-indigo-500 text-white'
                    } }}">
                        {{ match($ticket->status) {
                            'pending' => 'Pending',
                            'received' => 'Unit Diterima',
                            'diagnosing' => 'Diagnosa',
                            'waiting_approval' => 'Menunggu Approval',
                            'repairing' => 'Sedang Dikerjakan',
                            'payment_verification' => 'Verifikasi Bayar',
                            'done' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            'refunded' => 'Refund',
                            default => str_replace('_', ' ', $ticket->status)
                        } }}
                    </span>
                </div>
                <div class="p-6">
                    <form wire:submit.prevent="updateStatus">
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pilih Status Baru</label>
                            <select wire:model="newStatus" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="pending">Menunggu (Pending)</option>
                                <option value="received">Unit Diterima (Received)</option>
                                <option value="diagnosing">Diagnosa / Cek Unit (Diagnosing)</option>
                                <option value="waiting_approval">Menunggu Persetujuan Pelanggan</option>
                                <option value="repairing">Sedang Dikerjakan (Repairing)</option>
                                <option value="payment_verification">Verifikasi Pembayaran</option>
                                <option value="done">Selesai (Done)</option>
                                <option value="cancelled">Dibatalkan (Cancelled)</option>
                                <option value="refunded">Refund (Retur Dana / Batal)</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Catatan Internal / Pesan ke Pelanggan</label>
                            <textarea wire:model="note" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Tuliskan catatan progres atau pesan perbaikan..."></textarea>
                        </div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                            Simpan Status & Catatan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Invoice Items & Payment -->
            @if(auth()->user()->hasRole(['super_admin', 'admin']))
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-800 px-6 py-4 flex justify-between items-center gap-2 overflow-x-auto">
                    <h3 class="font-bold text-white whitespace-nowrap">Tagihan & Suku Cadang Terpakai</h3>
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
                            🖨️ Cetak Nota
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if(in_array($ticket->status, ['cancelled', 'refunded']) || $ticket->payment_status === 'refunded')
                        <div class="bg-rose-50 border-l-4 border-rose-500 p-3 mb-5 rounded-r">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-rose-500 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <div class="text-xs font-bold text-rose-800 uppercase">Order {{ strtoupper($ticket->status) }} ({{ strtoupper($ticket->payment_status) }})</div>
                                    <div class="text-xs text-rose-700 mt-0.5">Modal sparepart / biaya teknisi yang tercatat di bawah ini akan dihitung sebagai <strong>beban kerugian modal (nilai minus)</strong> pada laporan laba rugi.</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Item List -->
                    <div class="mb-6">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-xs">
                                <tr>
                                    <th class="px-2 py-2">Item</th>
                                    <th class="px-2 py-2 w-12 text-center">Qty</th>
                                    <th class="px-2 py-2 w-20 text-right text-gray-400">Modal</th>
                                    <th class="px-2 py-2 w-24 text-right">Tagihan</th>
                                    <th class="px-2 py-2 w-24 text-right">Total</th>
                                    <th class="px-2 py-2 w-8"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @php $totalCapitalUsed = 0; @endphp
                                @forelse($ticket->items as $item)
                                    @php $totalCapitalUsed += $item->capital_price * $item->quantity; @endphp
                                    <tr>
                                        <td class="px-2 py-2">
                                            <div class="font-medium text-gray-800">{{ $item->description }}</div>
                                            <div class="text-[10px] text-gray-400">
                                                {{ $item->is_spare_part ? '📦 Spare Part' : '🛠️ Jasa Servis' }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 text-center">{{ $item->quantity }}</td>
                                        <td class="px-2 py-2 text-right font-mono text-xs text-gray-400">
                                            Rp {{ number_format($item->capital_price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                        <td class="px-2 py-2 text-right font-mono text-gray-600">{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-2 py-2 text-right font-mono font-medium text-gray-900">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                        <td class="px-2 py-2 text-right">
                                            <button wire:click="removeItem({{ $item->id }})" class="text-red-400 hover:text-red-600 font-bold">
                                                &times;
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-2 py-4 text-center text-gray-400 italic">Belum ada sparepart / jasa ditambahkan.</td>
                                    </tr>
                                @endforelse

                                @if($totalCapitalUsed > 0)
                                    <tr class="bg-gray-50/50 text-xs text-gray-500">
                                        <td colspan="4" class="px-2 py-1.5 text-right font-semibold">Total Modal/HPP Terpakai:</td>
                                        <td class="px-2 py-1.5 text-right font-mono font-bold text-rose-600">Rp {{ number_format($totalCapitalUsed, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                @endif

                                @if($ticket->discount_amount > 0)
                                    <tr class="text-gray-600">
                                        <td colspan="4" class="px-2 py-2 text-right">Subtotal Tagihan</td>
                                        <td class="px-2 py-2 text-right font-mono">{{ number_format($ticket->subtotal, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                    <tr class="text-green-600">
                                        <td colspan="4" class="px-2 py-2 text-right">
                                            Discount <span class="text-xs bg-green-100 text-green-800 px-1 rounded uppercase">{{ $ticket->coupon_code }}</span>
                                        </td>
                                        <td class="px-2 py-2 text-right font-mono">- {{ number_format($ticket->discount_amount, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                @endif

                                <tr class="bg-gray-100 font-bold text-gray-800">
                                    <td colspan="4" class="px-2 py-3 text-right">TOTAL TAGIHAN</td>
                                    <td class="px-2 py-3 text-right font-mono text-base text-gray-900">Rp {{ number_format($ticket->total_cost, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Item Form with QR Scanner -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6" x-data="{ 
                        showCameraScanner: false,
                        html5QrCode: null,
                        instantAdd: true,
                        scanStatusMessage: '',
                        scanStatusType: '',
                        
                        startScanner() {
                            this.showCameraScanner = true;
                            this.$nextTick(() => {
                                if (!this.html5QrCode) {
                                    this.html5QrCode = new Html5Qrcode('qr-reader-video');
                                }
                                const config = { fps: 10, qrbox: { width: 220, height: 220 } };
                                this.html5QrCode.start({ facingMode: 'environment' }, config, (decodedText) => {
                                    this.onScanSuccess(decodedText);
                                }, (errorMessage) => {
                                    // ignore scan frame errors
                                }).catch((err) => {
                                    console.error('Camera start error', err);
                                    this.scanStatusMessage = 'Gagal mengakses kamera. Pastikan izin kamera aktif.';
                                    this.scanStatusType = 'error';
                                });
                            });
                        },
                        stopScanner() {
                            if (this.html5QrCode && this.html5QrCode.isScanning) {
                                this.html5QrCode.stop().then(() => {
                                    this.showCameraScanner = false;
                                }).catch(err => {
                                    this.showCameraScanner = false;
                                });
                            } else {
                                this.showCameraScanner = false;
                            }
                        },
                        onScanSuccess(decodedText) {
                            try {
                                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                                const osc = audioCtx.createOscillator();
                                osc.type = 'sine';
                                osc.frequency.setValueAtTime(880, audioCtx.currentTime);
                                osc.connect(audioCtx.destination);
                                osc.start();
                                osc.stop(audioCtx.currentTime + 0.1);
                            } catch(e){}

                            this.scanStatusMessage = 'Scan Berhasil: ' + decodedText;
                            this.scanStatusType = 'success';

                            @this.call('scanPart', decodedText, this.instantAdd);
                        }
                    }">
                        <!-- Flash message from scan -->
                        @if(session()->has('scan_success'))
                            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 p-2.5 rounded-md mb-3 text-xs font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span>{{ session('scan_success') }}</span>
                            </div>
                        @endif

                        @if(session()->has('scan_error'))
                            <div class="bg-rose-50 border border-rose-300 text-rose-800 p-2.5 rounded-md mb-3 text-xs font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                <span>{{ session('scan_error') }}</span>
                            </div>
                        @endif

                        <!-- Quick Barcode / SKU Scan Box -->
                        <div class="bg-indigo-50/70 p-3 rounded-lg border border-indigo-100 mb-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold uppercase text-indigo-900 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    Scan QR Code / Barcode (Opsional)
                                </span>
                                <button type="button" @click="startScanner()" class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-2.5 py-1 rounded shadow-sm flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Buka Kamera Scan
                                </button>
                            </div>
                            <div class="flex gap-2">
                                <input type="text" wire:model="scanInput" wire:keydown.enter.prevent="handleScanSubmit(true)" placeholder="Scan barcode scanner USB / ketik kode (contoh: SP-0001) lalu Enter..." class="block w-full rounded-md border-gray-300 shadow-sm text-xs font-mono focus:ring-indigo-500 focus:border-indigo-500">
                                <button type="button" wire:click="handleScanSubmit(true)" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-3 py-1.5 rounded-md font-semibold whitespace-nowrap">
                                    + Tambah
                                </button>
                            </div>
                        </div>

                        <!-- Manual Item Header -->
                        <h4 class="text-xs font-bold text-gray-700 uppercase mb-3 flex justify-between items-center">
                            <span>Input Manual / Pilih Sparepart</span>
                            <span class="text-[10px] text-gray-400 font-normal">Isi modal untuk hitungan laba/rugi</span>
                        </h4>

                        <div class="grid grid-cols-1 gap-3">
                            <!-- Select Inventory -->
                            <div x-data="{ open: false, search: @entangle('searchPart') }" class="relative">
                                <div @click="open = !open" class="block w-full rounded-md border border-gray-300 shadow-sm text-sm bg-white px-3 py-2 cursor-pointer flex justify-between items-center">
                                    <span class="truncate">
                                        {{ $selectedPartId ? $spareParts->firstWhere('id', $selectedPartId)?->name ?? '-- Pilih Dari Stok Sparepart (Opsional) --' : '-- Pilih Dari Stok Sparepart (Opsional) --' }}
                                    </span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                
                                <div x-show="open" @click.away="open = false" class="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg border border-gray-200">
                                    <div class="p-2 border-b border-gray-100">
                                        <input type="text" wire:model.live.debounce.300ms="searchPart" placeholder="Cari suku cadang atau kode..." class="block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <ul class="max-h-60 overflow-y-auto py-1">
                                        <li @click="$wire.set('selectedPartId', ''); open = false" class="px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 cursor-pointer">
                                            -- Input Manual (Bukan dari Stok) --
                                        </li>
                                        @foreach($spareParts as $part)
                                            <li @click="$wire.set('selectedPartId', '{{ $part->id }}'); open = false" class="px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 cursor-pointer flex justify-between items-center">
                                                <div>
                                                    <span class="font-medium text-gray-900">{{ $part->name }}</span>
                                                    <span class="font-mono text-[10px] text-indigo-600 ml-1 bg-indigo-50 px-1.5 py-0.5 rounded">{{ $part->item_code }}</span>
                                                </div>
                                                <span class="text-gray-500 font-mono text-xs">Modal: Rp {{ number_format($part->capital_price, 0, ',', '.') }} | Jual: Rp {{ number_format($part->price, 0, ',', '.') }}</span>
                                            </li>
                                        @endforeach
                                        @if($spareParts->isEmpty())
                                            <li class="px-3 py-2 text-sm text-gray-500 text-center italic">Tidak ditemukan</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Description & Quick Tags -->
                            <div>
                                <input type="text" wire:model="newItemDescription" placeholder="Uraian Jasa / Nama Sparepart (misal: LCD Replacement, IC Power, dll.)" class="block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                <div class="flex flex-wrap gap-2 mt-1.5">
                                    <button type="button" wire:click="$set('newItemDescription', 'Biaya Jasa Servis'); $set('newItemIsSparePart', false);" class="text-[11px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-200 hover:bg-blue-100">
                                        + Jasa Servis
                                    </button>
                                    <button type="button" wire:click="$set('newItemDescription', 'Biaya Pengecekan / Diagnosa Unit'); $set('newItemIsSparePart', false);" class="text-[11px] bg-gray-100 text-gray-700 px-2 py-0.5 rounded border border-gray-300 hover:bg-gray-200">
                                        + Biaya Diagnosa
                                    </button>
                                    <button type="button" wire:click="$set('newItemDescription', 'Part Rusak Saat Pengerjaan (Hangus)'); $set('newItemPrice', 0); $set('newItemIsSparePart', true);" class="text-[11px] bg-rose-50 text-rose-700 px-2 py-0.5 rounded border border-rose-200 hover:bg-rose-100">
                                        + Part Hangus (Modal Terpakai)
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Grid: Modal, Price, Qty -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-gray-500 mb-0.5">Harga Modal / HPP (Rp)</label>
                                    <input type="number" wire:model="newItemCapitalPrice" placeholder="Modal/HPP" class="block w-full rounded-md border-gray-300 shadow-sm text-sm font-mono" title="Harga modal yang dikeluarkan toko">
                                    @error('newItemCapitalPrice') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-gray-500 mb-0.5">Harga Jual / Tagih (Rp)</label>
                                    <input type="number" wire:model="newItemPrice" placeholder="Harga Tagihan" class="block w-full rounded-md border-gray-300 shadow-sm text-sm font-mono" title="Harga yang ditagihkan ke customer (0 jika digratiskan/cancel)">
                                    @error('newItemPrice') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-gray-500 mb-0.5">Jumlah (Qty)</label>
                                    <input type="number" wire:model="newItemQty" placeholder="1" class="block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                    @error('newItemQty') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <label class="inline-flex items-center text-xs text-gray-700 cursor-pointer">
                                    <input type="checkbox" wire:model="newItemIsSparePart" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2">Kategori Suku Cadang / Spare Part Fisik</span>
                                </label>
                                <button wire:click="addItem" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700 shadow-sm">
                                    + Tambah Item
                                </button>
                            </div>
                        </div>

                        <!-- Camera Scanner Modal -->
                        <div x-show="showCameraScanner" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="scan-modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="stopScanner()"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                                    <div class="bg-indigo-600 px-6 py-4 flex justify-between items-center text-white">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                            <h3 class="font-bold text-base">Scanner QR Code Spare Part</h3>
                                        </div>
                                        <button type="button" @click="stopScanner()" class="text-white hover:text-gray-200 text-2xl font-bold">&times;</button>
                                    </div>

                                    <div class="p-6 text-center">
                                        <p class="text-xs text-gray-500 mb-3">Arahkan kamera ke stiker QR Code suku cadang.</p>
                                        
                                        <!-- Video Container -->
                                        <div id="qr-reader-video" class="w-full rounded-xl overflow-hidden bg-black border-2 border-indigo-500 mx-auto" style="min-height: 250px;"></div>

                                        <div class="mt-4 flex items-center justify-center">
                                            <label class="inline-flex items-center text-xs text-gray-700 cursor-pointer font-medium">
                                                <input type="checkbox" x-model="instantAdd" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                                <span class="ml-2">⚡ Langsung tambahkan ke tagihan saat scan</span>
                                            </label>
                                        </div>

                                        <template x-if="scanStatusMessage">
                                            <div class="mt-3 p-2 rounded text-xs font-semibold" :class="scanStatusType === 'success' ? 'bg-green-100 text-green-800' : 'bg-rose-100 text-rose-800'" x-text="scanStatusMessage"></div>
                                        </template>
                                    </div>

                                    <div class="bg-gray-50 px-6 py-3 flex justify-between items-center border-t border-gray-100">
                                        <span class="text-[11px] text-gray-400">Bisa scan berulang kali</span>
                                        <button type="button" @click="stopScanner()" class="px-4 py-2 rounded-md border border-gray-300 text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50">
                                            Selesai / Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Status & Verification -->
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-bold text-gray-700">Status Pembayaran:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase
                                {{ match($ticket->payment_status) {
                                    'paid' => 'bg-green-100 text-green-800',
                                    'unpaid' => 'bg-red-100 text-red-800',
                                    'waiting_verification' => 'bg-yellow-100 text-yellow-800',
                                    'refunded' => 'bg-purple-100 text-purple-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                {{ match($ticket->payment_status) {
                                    'paid' => 'Lunas',
                                    'unpaid' => 'Belum Bayar',
                                    'waiting_verification' => 'Menunggu Verifikasi',
                                    'refunded' => 'Refund (Retur)',
                                    default => str_replace('_', ' ', $ticket->payment_status)
                                } }}
                            </span>
                        </div>

                        @if($ticket->payment_proof)
                            <div class="space-y-3 mb-4">
                                <p class="text-xs uppercase font-bold text-gray-500">Bukti Transfer dari Pelanggan:</p>
                                <a href="{{ Storage::url($ticket->payment_proof) }}" target="_blank" class="block group relative rounded-lg overflow-hidden border border-gray-200">
                                    <img src="{{ Storage::url($ticket->payment_proof) }}" class="w-full h-32 object-cover group-hover:opacity-75 transition">
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        <span class="bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs font-semibold">Lihat Bukti Penuh</span>
                                    </div>
                                </a>
                                
                                @if($ticket->payment_status !== 'paid')
                                    <button wire:click="approvePayment" class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none transition">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Verifikasi & Terima Pembayaran
                                    </button>
                                @endif
                            </div>
                        @else
                            @if($ticket->payment_status === 'unpaid')
                            <div class="text-center py-4 bg-gray-50 rounded-lg border border-dashed border-gray-300 mb-3">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-1 text-xs text-gray-500">Belum ada bukti pembayaran transfer yang diunggah.</p>
                            </div>
                            @endif
                        @endif

                        <!-- Action Buttons: Paid / Refund / Cancel -->
                        <div class="space-y-2 pt-2">
                            @if($ticket->payment_status !== 'paid')
                                <button wire:click="approvePaymentDirect" wire:confirm="Tandai pembayaran sebagai LUNAS tunai/langsung?" class="w-full flex justify-center items-center py-2 px-4 border border-green-600 rounded-md shadow-sm text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none transition">
                                    <svg class="h-4 w-4 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tandai Pembayaran LUNAS (Cash/Direct)
                                </button>
                            @endif

                            <div class="grid grid-cols-2 gap-2">
                                @if($ticket->payment_status !== 'refunded')
                                    <button wire:click="markAsRefunded" wire:confirm="Tandai pesanan ini sebagai REFUND? Dana akan ditandai dikembalikan." class="flex justify-center items-center py-2 px-3 border border-purple-300 rounded-md text-xs font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 transition">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                        </svg>
                                        Tandai Refund
                                    </button>
                                @endif

                                @if($ticket->status !== 'cancelled')
                                    <button wire:click="markAsCancelled" wire:confirm="Apakah Anda yakin ingin MEMBATALKAN (Cancel) pesanan ini?" class="flex justify-center items-center py-2 px-3 border border-rose-300 rounded-md text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 transition">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Batalkan (Cancel)
                                    </button>
                                @endif

                                @if($ticket->payment_status === 'paid' || $ticket->payment_status === 'refunded')
                                    <button wire:click="markAsUnpaid" class="flex justify-center items-center py-2 px-3 border border-gray-300 rounded-md text-xs font-medium text-gray-600 bg-white hover:bg-gray-50 transition col-span-2">
                                        Reset ke Belum Bayar (Unpaid)
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
