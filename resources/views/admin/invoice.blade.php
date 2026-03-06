<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ substr($ticket->id, 0, 8) }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 40px; color: #333; max-width: 800px; margin: 0 auto; line-height: 1.5; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 2px solid #2267BC; padding-bottom: 20px; }
        .logo img { height: 60px; width: auto; display: block; margin-bottom: 10px; }
        .logo p { margin: 0; font-size: 14px; color: #555; line-height: 1.4; }
        .invoice-title { text-align: right; }
        .invoice-title h1 { margin: 0 0 5px; color: #2267BC; font-size: 32px; letter-spacing: 1px; }
        .invoice-title p { margin: 2px 0; font-size: 14px; color: #555; }
        
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .info-col { width: 48%; }
        .info-col h3 { font-size: 14px; text-transform: uppercase; color: #2267BC; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .info-col p { margin: 5px 0; font-size: 14px; }

        table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        th { text-align: left; padding: 12px 10px; border-bottom: 2px solid #2267BC; font-size: 12px; text-transform: uppercase; color: #333; background-color: #f8f9fa; }
        td { padding: 12px 10px; border-bottom: 1px solid #eee; font-size: 14px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row td { font-weight: bold; font-size: 16px; border-top: 2px solid #2267BC; border-bottom: none; }
        .subtotal-row td { padding-top: 15px; }
        
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #555; border-top: 1px solid #eee; padding-top: 20px; }
        .footer p { margin: 5px 0; }
        .warranty-note { font-style: italic; color: #777; margin-top: 15px !important; font-size: 11px; }
        
        @media print {
            @page { margin: 0; }
            body { padding: 2cm; max-width: 100%; }
            .no-print { display: none; }
            .header { border-bottom-color: #2267BC !important; }
            th { border-bottom-color: #2267BC !important; background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .total-row td { border-top-color: #2267BC !important; }
        }
    </style>
</head>
<body>

    @if(!isset($isPdf) || !$isPdf)
    <div class="no-print" style="margin-bottom: 20px; display: flex; justify-content: flex-end; gap: 10px;">
        @php
            $waNumber = preg_replace('/[^0-9]/', '', $ticket->customer_wa);
            if (str_starts_with($waNumber, '0')) {
                $waNumber = '62' . substr($waNumber, 1);
            }
            $statusText = strtoupper(str_replace('_', ' ', $ticket->payment_status));
            $formattedTotal = number_format($ticket->total_cost, 0, ',', '.');
            $detailLink = route('tracking', $ticket->id);
            $waText = "Halo *{$ticket->customer_name}*, berikut adalah nota/invoice perbaikan *{$ticket->device_model}* Anda di CoreFix Service.\n\nTotal Tagihan: *Rp {$formattedTotal}*\nStatus Pembayaran: *{$statusText}*\n\nDetail lengkap dapat dilihat pada tautan berikut:\n{$detailLink}\n\nTerima kasih atas kepercayaannya.";
        @endphp
        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waText) }}" target="_blank" style="background: #25D366; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center;">
            <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.489-1.761-1.663-2.06-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
            Kirim WhatsApp
        </a>
        <button onclick="window.print()" style="background: #2267BC; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center;">
            <svg style="width: 18px; height: 18px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Invoice
        </button>
    </div>
    @endif

    <div class="header">
        <div class="logo">
            @php
                $logoPath = public_path('logo.png');
                $logoSrc = asset('logo.png?v=5');
                if (file_exists($logoPath)) {
                    $logoData = base64_encode(file_get_contents($logoPath));
                    $logoSrc = 'data:image/png;base64,' . $logoData;
                }
            @endphp
            <img src="{{ $logoSrc }}" alt="CoreFix Logo">
            <p><strong>CoreFix Service</strong><br>
            Professional Gadget Repair<br>
            +62 895-0904-5088</p>
        </div>
        <div class="invoice-title">
            <h1>INVOICE</h1>
            <p><strong>Ref:</strong> #{{ substr($ticket->id, 0, 8) }}</p>
            <p><strong>Tanggal:</strong> {{ date('d M Y') }}</p>
            <p><strong>Status:</strong> <span style="background: {{ $ticket->payment_status == 'paid' ? '#def7ec' : '#fde8e8' }}; color: {{ $ticket->payment_status == 'paid' ? '#03543f' : '#9b1c1c' }}; padding: 2px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">{{ strtoupper(str_replace('_', ' ', $ticket->payment_status)) }}</span></p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-col">
            <h3>Ditagihkan Kepada</h3>
            <p><strong>{{ $ticket->customer_name }}</strong></p>
            <p>{{ $ticket->customer_wa }}</p>
            <p style="max-width: 250px; color: #555;">{{ $ticket->customer_address }}</p>
        </div>
        <div class="info-col">
            <h3>Detail Perangkat</h3>
            <p><strong>Model:</strong> {{ $ticket->device_model }}</p>
            <p><strong>Keluhan:</strong> {{ $ticket->issue_description }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Deskripsi Layanan / Sparepart</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $calculatedSubtotal = 0; @endphp
            @foreach($ticket->items as $item)
            @php $calculatedSubtotal += $item->price * $item->quantity; @endphp
            <tr>
                <td>{{ $item->description }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            <!-- Subtotal -->
            <tr class="subtotal-row">
                <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                <td class="text-right">Rp {{ number_format($calculatedSubtotal, 0, ',', '.') }}</td>
            </tr>

            <!-- Discount -->
            @if($ticket->discount_amount > 0)
            <tr>
                <td colspan="3" class="text-right" style="color: #dc2626;">Diskon {{ $ticket->coupon_code ? '('.$ticket->coupon_code.')' : '' }}</td>
                <td class="text-right" style="color: #dc2626;">- Rp {{ number_format($ticket->discount_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
            
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL TAGIHAN</td>
                <td class="text-right">Rp {{ number_format($ticket->total_cost, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>CoreFix Service</strong></p>
        <p>Jl. Tamtama, kendayaan, Penyangkringan, Kec. Weleri, Kabupaten Kendal, Jawa Tengah 51355</p>
        <p class="warranty-note">Terimakasih telah mempercayakan perbaikan perangkat Anda kepada kami. Garansi berlaku sesuai ketentuan yang diberikan. Kerusakan akibat jatuh, terkena air atau human error tidak termasuk garansi.</p>
    </div>

</body>
</html>
