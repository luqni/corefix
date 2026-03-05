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
            body { padding: 0; max-width: 100%; }
            .no-print { display: none; }
            .header { border-bottom-color: #2267BC !important; }
            th { border-bottom-color: #2267BC !important; background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .total-row td { border-top-color: #2267BC !important; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #2267BC; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold; font-size: 14px;">Cetak Invoice</button>
    </div>

    <div class="header">
        <div class="logo">
            <img src="{{ asset('logo.png?v=5') }}" alt="CoreFix Logo">
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
