<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            background: #fff;
            padding: 20px;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        /* Header Layout */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .brand-section h1 {
            color: #28a745;
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .brand-section p {
            color: #777;
            margin: 0;
            font-size: 14px;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-details h2 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 18px;
        }

        .invoice-details p {
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
            color: #555;
        }

        /* Info Grid */
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .info-col {
            width: 48%;
        }

        .info-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 5px;
        }

        .info-content {
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }

        /* Table */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .invoice-table th {
            background: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #ddd;
            font-size: 14px;
        }

        .invoice-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #555;
            font-size: 14px;
        }

        .invoice-table td.amount {
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        .invoice-table tr:last-child td {
            border-bottom: none;
        }

        /* Totals */
        .totals-section {
            display: flex;
            justify-content: flex-end;
        }

        .totals-table {
            width: 300px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 0;
            font-size: 14px;
        }

        .totals-table td:last-child {
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        .totals-table .grand-total {
            font-size: 18px;
            color: #28a745;
            border-top: 2px solid #f0f0f0;
            padding-top: 10px;
            margin-top: 10px;
        }

        /* Print Controls */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-print { background: #3C50E0; color: white; }
        .btn-close { background: #64748b; color: white; margin-left: 10px; }
        .btn:hover { opacity: 0.9; }

        @media print {
            .no-print { display: none; }
            .invoice-container { box-shadow: none; border: none; padding: 0; }
            body { padding: 0; background: white; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">
            Cetak Invoice / PDF
        </button>
        <button onclick="window.close()" class="btn btn-close">
            Tutup
        </button>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="brand-section">
                <h1>KrupuKruzzz</h1>
                <p>Solusi Camilan Kerupuk Berkualitas</p>
                <div style="margin-top: 10px; font-size: 12px; color: #777;">
                    Dusun Garas RT 0001 RW 0001 Desa Palembon<br>
                    Kecamatan Kanor, Kabupaten Bojonegoro<br>
                    Jawa Timur, Indonesia
                </div>
            </div>
            <div class="invoice-details">
                <h2>INVOICE</h2>
                <p>
                    <strong>No. Invoice:</strong> #{{ $order->order_number }}<br>
                    <strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}<br>
                    <strong>Status:</strong> <span style="text-transform: uppercase;">{{ $order->status }}</span>
                </p>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="info-section">
            <div class="info-col">
                <div class="info-title">Penerima</div>
                <div class="info-content">
                    <strong>{{ $order->name }}</strong><br>
                    {{ $order->phone ?? '-' }}<br>
                    {{ $order->email ?? '-' }}<br>
                    <br>
                    <div style="max-width: 300px;">
                        {{ $order->address }}<br>
                        {{ $order->city ? $order->city . ',' : '' }} {{ $order->province }}<br>
                        {{ $order->postal_code ? 'Kode Pos: ' . $order->postal_code : '' }}
                    </div>
                </div>
            </div>
            <div class="info-col" style="text-align: right;">
                <div class="info-title">Informasi Pengiriman</div>
                <div class="info-content">
                    @if($order->tracking_number)
                        <strong>No. Resi:</strong><br>
                        <span style="font-size: 16px; background: #f0f0f0; padding: 2px 8px; border-radius: 4px;">
                            {{ $order->tracking_number }}
                        </span><br>
                        <span style="color: #777; font-size: 12px;">
                            {{ strtoupper($order->shipping_courier ?? 'Ekspedisi') }} 
                            {{ strtoupper($order->shipping_service ?? '') }}
                        </span>
                    @else
                        <span style="color: #999; font-style: italic;">Belum ada resi</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 45%;">Item Produk</th>
                    <th style="width: 15%; text-align: center;">Qty</th>
                    <th style="width: 15%; text-align: right;">Harga</th>
                    <th style="width: 20%; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                @php
                    $productName = $item->product_name ?? ($item->product->name ?? 'Produk tidak ditemukan');
                    $price = $item->price;
                    $qty = $item->quantity;
                    $subtotal = $item->subtotal > 0 ? $item->subtotal : ($price * $qty);
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $productName }}</strong>
                    </td>
                    <td style="text-align: center;">{{ $qty }}</td>
                    <td style="text-align: right;">Rp {{ number_format($price, 0, ',', '.') }}</td>
                    <td class="amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td>Subtotal Produk</td>
                    <td>Rp {{ number_format($order->subtotal ?? $order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Ongkos Kirim</td>
                    <td>Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr class="grand-total">
                    <td style="font-weight: bold; padding-top: 15px;">TOTAL BAYAR</td>
                    <td style="font-weight: bold; color: #28a745; font-size: 20px; padding-top: 15px;">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 60px; border-top: 1px solid #eee; padding-top: 20px; text-align: center; color: #999; font-size: 12px;">
            <p>Terima kasih telah berbelanja di KrupuKruzzz Store Application.</p>
            <p>Harap simpan invoice ini sebagai bukti pembayaran yang sah.</p>
        </div>
    </div>
</body>
</html>
