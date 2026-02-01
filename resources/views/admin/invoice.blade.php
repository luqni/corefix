<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $ticket->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 40px; color: #333; max-width: 800px; mx-auto; }
        .header { display: flex; justify-content: space-between; margin-bottom: 40px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .logo h1 { margin: 0; color: #4F46E5; }
        .logo p { margin: 5px 0 0; font-size: 14px; color: #777; }
        .invoice-details { text-align: right; }
        .invoice-details h2 { margin: 0 0 10px; }
        .invoice-details p { margin: 2px 0; font-size: 14px; }
        
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .info-col h3 { font-size: 14px; text-transform: uppercase; color: #777; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .info-col p { margin: 5px 0; font-size: 14px; }

        table { w-full; margin-bottom: 30px; border-collapse: collapse; width: 100%; }
        th { text-align: left; padding: 10px; border-bottom: 2px solid #eee; font-size: 12px; text-transform: uppercase; color: #777; }
        td { padding: 12px 10px; border-bottom: 1px solid #eee; font-size: 14px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row td { font-weight: bold; font-size: 16px; border-top: 2px solid #333; border-bottom: none; }
        
        .footer { text-align: center; margin-top: 60px; font-size: 12px; color: #aaa; border-top: 1px solid #eee; padding-top: 20px; }
        
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #4F46E5; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px;">Print Invoice</button>
    </div>

    <div class="header">
        <div class="logo">
            <h1>COREFIX</h1>
            <p>Professional Gadget Repair</p>
        </div>
        <div class="invoice-details">
            <h2>INVOICE</h2>
            <p><strong>Ref:</strong> #{{ substr($ticket->id, 0, 8) }}</p>
            <p><strong>Date:</strong> {{ date('d M Y') }}</p>
            <p><strong>Status:</strong> {{ strtoupper(str_replace('_', ' ', $ticket->payment_status)) }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-col">
            <h3>Billed To</h3>
            <p><strong>{{ $ticket->customer_name }}</strong></p>
            <p>{{ $ticket->customer_wa }}</p>
            <p style="max-width: 250px;">{{ $ticket->customer_address }}</p>
        </div>
        <div class="info-col">
            <h3>Device Details</h3>
            <p><strong>Model:</strong> {{ $ticket->device_model }}</p>
            <p><strong>Issue:</strong> {{ $ticket->issue_description }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Amount</th>
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
            <tr>
                <td colspan="3" class="text-right" style="border-top: 1px solid #eee; padding-top: 15px;"><strong>Subtotal</strong></td>
                <td class="text-right" style="border-top: 1px solid #eee; padding-top: 15px;">Rp {{ number_format($calculatedSubtotal, 0, ',', '.') }}</td>
            </tr>

            <!-- Discount -->
            @if($ticket->discount_amount > 0)
            <tr>
                <td colspan="3" class="text-right" style="color: #dc2626;">Discount {{ $ticket->coupon_code ? '('.$ticket->coupon_code.')' : '' }}</td>
                <td class="text-right" style="color: #dc2626;">- Rp {{ number_format($ticket->discount_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
            
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($ticket->total_cost, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Thank you for trusting Corefix.id!</p>
        <p>Garansi 10 hari untuk pergantian sparepart (S&K berlaku).</p>
        <p>Dusun keong No.67, RT.01/RW.07, Siwelut, Pamutih, Kec. Ulujami, Kabupaten Pemalang, Jawa Tengah 52371 | +6289509045088</p>
    </div>

</body>
</html>
