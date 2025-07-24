<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan {{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 58mm;
            margin: 0 auto;
            padding: 10px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: center;
        }

        .line {
            border-bottom: 1px dashed #000;
            margin: 8px 0;
        }

        ul {
            padding-left: 0;
            list-style: none;
            margin-bottom: 8px;
        }

        li {
            margin-bottom: 4px;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body onload="window.print(); setTimeout(() => window.close(), 500);">
    <div class="title">Grosirku</div>
    <div class="line"></div>
    <div>ID Pesanan: {{ $order->id }}</div>
    <div>Tanggal: {{ $order->created_at->format('d M Y H:i') }}</div>
    <div>Pelanggan: {{ $order->user->name }}</div>
    <div>Alamat: {{ $order->shipping_address }}</div>
    <div>Metode Pembayaran: {{ $order->payment_method }}</div>
    <div>Bank: {{ $order->bank_name }}</div>

    <div class="line"></div>

    <ul>
        @foreach ($order->items as $item)
            <li>
                {{ $item->product->name }} (x{{ $item->quantity }})<br>
                Rp {{ number_format($item->product->price * $item->quantity) }}
            </li>
        @endforeach
    </ul>

    <div class="line"></div>
    <div><strong>Total: Rp {{ number_format($order->total_price) }}</strong></div>

    @if ($order->note)
        <div>Catatan: {{ $order->note }}</div>
    @endif

    <div class="line"></div>

    <div class="footer">
        Halo {{ $order->user->name }} 👋<br>
        Terima kasih telah berbelanja<br>
        di <strong>Grosirku</strong> 😊
    </div>
</body>
</html>
