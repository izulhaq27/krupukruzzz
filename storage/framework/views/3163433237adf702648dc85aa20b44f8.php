<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo e($order->order_number); ?> - KrupuKruzzz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @media print {
            .no-print, .btn { display: none !important; }
            body { font-size: 12pt; }
            .container { max-width: 100% !important; padding: 0 !important; }
            .table th, .table td { padding: 4px !important; }
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .invoice-header {
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .company-info h1 {
            color: #28a745;
            font-weight: bold;
        }
        
        .invoice-info {
            background: #f8fff9;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        
        .total-box {
            background: #28a745;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .table thead {
            background-color: #28a745;
            color: white;
        }
        
        .status-badge {
            font-size: 0.9rem;
            padding: 5px 15px;
            border-radius: 20px;
        }
        
        .bg-pending { background-color: #ffc107; color: #000; }
        .bg-paid { background-color: #17a2b8; color: white; }
        .bg-processed { background-color: #007bff; color: white; }
        .bg-shipped { background-color: #28a745; color: white; }
        .bg-completed { background-color: #343a40; color: white; }
        .bg-cancelled { background-color: #dc3545; color: white; }
        
        .table tbody tr:hover {
            background-color: #f8fff9;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="invoice-container">
            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-between mb-4 no-print">
                <a href="<?php echo e(route('orders.show', $order->order_number)); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div>
                    <button onclick="window.print()" class="btn btn-success me-2">
                        <i class="bi bi-printer"></i> Print
                    </button>
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-list"></i> Semua Pesanan
                    </a>
                </div>
            </div>

            <!-- Kop Invoice -->
            <div class="invoice-header">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="text-success fw-bold mb-2">KrupuKruzzz</h1>
                        <p class="mb-1"><i class="bi bi-geo-alt"></i> Dusun Garas RT 0001 RW 0001 Desa Palembon</p>
                        <p class="mb-1">Kecamatan Kanor, Kabupaten Bojonegoro Jawa Timur</p>
                        <p class="mb-1"><i class="bi bi-telephone"></i> 816-1550-0168</p>
                        <p class="mb-0"><i class="bi bi-envelope"></i> krupukruzzz@gmail.com</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="invoice-info">
                            <h2 class="fw-bold text-success mb-3">INVOICE</h2>
                            <p class="mb-1"><strong>No. Invoice:</strong> <?php echo e($order->order_number); ?></p>
                            <p class="mb-1"><strong>Tanggal:</strong> <?php echo e($order->created_at->format('d F Y')); ?></p>
                            <p class="mb-0">
                                <strong>Status:</strong>
                                <?php
                                    $statusColors = [
                                        'pending' => 'bg-pending',
                                        'paid' => 'bg-paid',
                                        'processed' => 'bg-processed',
                                        'shipped' => 'bg-shipped',
                                        'completed' => 'bg-completed',
                                        'cancelled' => 'bg-cancelled',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu Pembayaran',
                                        'paid' => 'Dibayar',
                                        'processed' => 'Diproses',
                                        'shipped' => 'Dikirim',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                ?>
                                <span class="status-badge <?php echo e($statusColors[$order->status] ?? 'bg-secondary'); ?>">
                                    <?php echo e($statusLabels[$order->status] ?? $order->status); ?>

                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Pelanggan & Pengiriman -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3 text-success">
                                <i class="bi bi-person me-2"></i>Info Pelanggan
                            </h5>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td width="30%"><strong>Nama</strong></td>
                                    <td>: <?php echo e($order->user->name); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>: <?php echo e($order->email); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Telepon</strong></td>
                                    <td>: <?php echo e($order->phone); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td>: <?php echo e($order->address); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3 text-success">
                                <i class="bi bi-truck me-2"></i>Info Pengiriman
                            </h5>
                            <table class="table table-sm table-borderless mb-0">
                                <?php if($order->shipping_courier): ?>
                                <tr>
                                    <td width="40%"><strong>Kurir</strong></td>
                                    <td>: <?php echo e(strtoupper($order->shipping_courier)); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Layanan</strong></td>
                                    <td>: <?php echo e($order->shipping_service ?? 'REG'); ?></td>
                                </tr>
                                <?php if($order->tracking_number): ?>
                                <tr>
                                    <td><strong>No. Resi</strong></td>
                                    <td>: <?php echo e($order->tracking_number); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if($order->shipping_cost): ?>
                                <tr>
                                    <td><strong>Ongkir</strong></td>
                                    <td>: Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-muted">Belum ada info pengiriman</td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Item - SIMPLE TANPA GAMBAR -->
            <div class="mb-4">
                <h5 class="mb-3 text-success fw-bold">
                    <i class="bi bi-cart-check me-2"></i>Detail Pesanan
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th>Produk</th>
                                <th width="10%" class="text-center">Qty</th>
                                <th width="20%" class="text-end">Harga Satuan</th>
                                <th width="20%" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($index + 1); ?></td>
                                <td>
                                    <strong><?php echo e($item->product_name); ?></strong>
                                    <?php if($item->product_sku): ?>
                                    <br><small class="text-muted">SKU: <?php echo e($item->product_sku); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo e($item->quantity); ?></td>
                                <td class="text-end">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                                <td class="text-end fw-bold">Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="row">
                <div class="col-md-8">
                    <?php if($order->notes): ?>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold text-success mb-2">
                                <i class="bi bi-chat-left-text me-2"></i>Catatan
                            </h6>
                            <p class="mb-0"><?php echo e($order->notes); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <div class="total-box">
                        <h5 class="fw-bold mb-3">Ringkasan Pembayaran</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <strong>Rp <?php echo e(number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 0, ',', '.')); ?></strong>
                        </div>
                        
                        <?php if($order->shipping_cost): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim</span>
                            <strong>Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></strong>
                        </div>
                        <?php endif; ?>
                        
                        <hr class="my-3" style="border-color: rgba(255,255,255,0.5);">
                        
                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold mb-0">TOTAL</h5>
                            <h4 class="fw-bold mb-0">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></h4>
                        </div>
                        
                        <?php if($order->payment_type): ?>
                        <div class="mt-3 pt-3 border-top border-white">
                            <p class="mb-1"><strong>Metode Pembayaran:</strong></p>
                            <p class="mb-0"><?php echo e(strtoupper($order->payment_type)); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Footer & TTD -->
            <div class="row mt-5 pt-4 border-top">
                <div class="col-md-6 text-center">
                    <p>Hormat Kami,</p>
                    <br><br><br>
                    <p class="fw-bold">KrupuKruzzz</p>
                </div>
                <div class="col-md-6 text-center">
                    <p>Pelanggan,</p>
                    <br><br><br>
                    <p class="fw-bold"><?php echo e($order->user->name); ?></p>
                </div>
            </div>

            <!-- Note -->
            <div class="text-center mt-4 text-muted small">
                <p class="mb-0">Invoice ini sah dan dapat digunakan sebagai bukti pembayaran</p>
                <p class="mb-0">Terima kasih telah berbelanja di KrupuKruzzz</p>
            </div>
        </div>
    </div>

    <script>
        // Auto print jika diinginkan (opsional)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/orders/invoice.blade.php ENDPATH**/ ?>