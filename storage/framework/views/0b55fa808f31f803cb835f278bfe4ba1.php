

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- BREADCRUMB -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('orders.index')); ?>">Pesanan Saya</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
                </ol>
            </nav>

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold text-success mb-2">
                        <i class="bi bi-receipt"></i> Detail Pesanan
                    </h1>
                    <p class="text-muted mb-0">No. Pesanan: <strong><?php echo e($order->order_number); ?></strong></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="<?php echo e(route('orders.invoice', $order->order_number)); ?>" class="btn btn-success">
                        <i class="bi bi-printer"></i> Invoice
                    </a>
                </div>
            </div>

            <!-- NOTIFICATION -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="bi bi-exclamation-triangle"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- LEFT COLUMN -->
                <div class="col-lg-8">
                    <!-- STATUS TIMELINE -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-clock-history text-success me-2"></i> Status Pesanan
                            </h5>
                            
                            <?php
                                $timeline = [
                                    'pending' => ['label' => 'Menunggu Pembayaran', 'icon' => 'clock'],
                                    'paid' => ['label' => 'Pembayaran Diterima', 'icon' => 'check-circle'],
                                    'processed' => ['label' => 'Pesanan Diproses', 'icon' => 'gear'],
                                    'shipped' => ['label' => 'Pesanan Dikirim', 'icon' => 'truck'],
                                    'completed' => ['label' => 'Pesanan Selesai', 'icon' => 'check2-circle'],
                                ];
                                
                                $currentStatus = $order->status;
                                $statusIndex = array_keys($timeline);
                            ?>
                            
                            <div class="timeline">
                                <?php $__currentLoopData = $timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $isActive = in_array($status, array_slice($statusIndex, 0, array_search($currentStatus, $statusIndex) + 1));
                                        $isCurrent = $status == $currentStatus;
                                    ?>
                                    <div class="timeline-item <?php echo e($isActive ? 'active' : ''); ?> <?php echo e($isCurrent ? 'current' : ''); ?>">
                                        <div class="timeline-icon">
                                            <i class="bi bi-<?php echo e($info['icon']); ?>"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="fw-bold"><?php echo e($info['label']); ?></h6>
                                            <?php if($isActive): ?>
                                                <?php switch($status):
                                                    case ('pending'): ?>
                                                        <p class="text-muted small mb-0">Menunggu pembayaran dari Anda</p>
                                                        <?php break; ?>
                                                    <?php case ('paid'): ?>
                                                        <p class="text-muted small mb-0">Pembayaran telah dikonfirmasi</p>
                                                        <?php break; ?>
                                                    <?php case ('processed'): ?>
                                                        <p class="text-muted small mb-0">Pesanan sedang dipersiapkan</p>
                                                        <?php break; ?>
                                                    <?php case ('shipped'): ?>
                                                        <p class="text-muted small mb-0">
                                                            <?php if($order->shipped_at): ?>
                                                                Dikirim pada <?php echo e($order->shipped_at->format('d F Y, H:i')); ?>

                                                            <?php endif; ?>
                                                        </p>
                                                        <?php break; ?>
                                                    <?php case ('completed'): ?>
                                                        <p class="text-muted small mb-0">
                                                            <?php if($order->delivered_at): ?>
                                                                Selesai pada <?php echo e($order->delivered_at->format('d F Y, H:i')); ?>

                                                            <?php endif; ?>
                                                        </p>
                                                        <?php break; ?>
                                                <?php endswitch; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                    <!-- ITEMS -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-cart text-success me-2"></i> Item Pesanan
                            </h5>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($item->product && $item->product->image): ?>
                                                        <img src="<?php echo e(asset('storage/' . $item->product->image)); ?>" 
                                                             alt="<?php echo e($item->product_name); ?>" 
                                                             class="rounded me-3" 
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="fw-bold mb-1"><?php echo e($item->product_name); ?></h6>
                                                        <small class="text-muted">SKU: <?php echo e($item->product_sku ?? '-'); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle"><?php echo e($item->quantity); ?></td>
                                            <td class="text-end align-middle">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                                            <td class="text-end align-middle fw-bold">
                                                Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?>

                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">
                    <!-- INFO PESANAN -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-info-circle text-success me-2"></i> Info Pesanan
                            </h5>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Tanggal Pesanan</small>
                                <strong><?php echo e($order->created_at->format('d F Y, H:i')); ?></strong>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block">Status</small>
                                <?php
                                    $statusConfig = [
                                        'pending' => ['color' => 'warning', 'label' => 'Menunggu Pembayaran'],
                                        'paid' => ['color' => 'info', 'label' => 'Dibayar'],
                                        'processed' => ['color' => 'primary', 'label' => 'Diproses'],
                                        'shipped' => ['color' => 'success', 'label' => 'Dikirim'],
                                        'completed' => ['color' => 'dark', 'label' => 'Selesai'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['color' => 'secondary', 'label' => $order->status];
                                ?>
                                <span class="badge bg-<?php echo e($config['color']); ?> px-3 py-2">
                                    <?php echo e($config['label']); ?>

                                </span>
                            </div>
                            
                            <?php if($order->notes): ?>
                            <div class="mb-3">
                                <small class="text-muted d-block">Catatan</small>
                                <p class="mb-0"><?php echo e($order->notes); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- INFO PENGIRIMAN -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-truck text-success me-2"></i> Info Pengiriman
                            </h5>
                            
                            <?php if($order->shipping_courier): ?>
                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Kurir</small>
                                    <strong class="text-uppercase"><?php echo e(strtoupper($order->shipping_courier)); ?></strong>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Layanan</small>
                                    <strong><?php echo e($order->shipping_service ?? 'REG'); ?></strong>
                                </div>
                                
                                <?php if($order->tracking_number): ?>
                                <div class="col-12">
                                    <small class="text-muted d-block">No. Resi</small>
                                    <div class="d-flex align-items-center">
                                        <code class="me-2 fs-6"><?php echo e($order->tracking_number); ?></code>
                                        <?php if($order->tracking_link): ?>
                                        <a href="<?php echo e($order->tracking_link); ?>" target="_blank" 
                                           class="btn btn-sm btn-success">
                                            <i class="bi bi-box-arrow-up-right"></i> Lacak
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($order->shipping_cost): ?>
                                <div class="col-12">
                                    <small class="text-muted d-block">Ongkir</small>
                                    <strong>Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></strong>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <p class="text-muted mb-0">Belum ada info pengiriman</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- RINGKASAN PEMBAYARAN -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-currency-dollar text-success me-2"></i> Ringkasan Pembayaran
                            </h5>
                            
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
                            
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total</span>
                                <h4 class="fw-bold text-success">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></h4>
                            </div>
                            
                            <?php if($order->payment_type): ?>
                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted d-block">Metode Pembayaran</small>
                                <strong><?php echo e(strtoupper($order->payment_type)); ?></strong>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- ========== AKSI TOMBOL YANG BERFUNGSI ========== -->
                    <?php if($order->status == 'pending'): ?>
                    <div class="mt-4">
                        <!-- TOMBOL BAYAR SEKARANG -->
                        <form action="<?php echo e(route('orders.pay', $order->order_number)); ?>" method="POST" class="mb-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success w-100 py-3" 
                                    onclick="return confirm('Lanjutkan pembayaran untuk pesanan <?php echo e($order->order_number); ?>?')">
                                <i class="bi bi-credit-card me-2"></i> Bayar Sekarang
                            </button>
                        </form>
                        
                        <!-- TOMBOL BATALKAN PESANAN -->
                        <form action="<?php echo e(route('orders.cancel', $order->order_number)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-danger w-100 py-2" 
                                    onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                <i class="bi bi-x-circle me-2"></i> Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($order->status == 'shipped'): ?>
                    <div class="mt-4">
                        <form action="<?php echo e(route('orders.confirm-received', $order->order_number)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success w-100 py-3" 
                                    onclick="return confirm('Konfirmasi pesanan sudah diterima?')">
                                <i class="bi bi-check-circle me-2"></i> Konfirmasi Diterima
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($order->status == 'completed'): ?>
                    <div class="mt-4">
                        <div class="alert alert-success">
                            <i class="bi bi-check2-circle me-2"></i>
                            Pesanan ini sudah selesai. Terima kasih telah berbelanja di KrupuKruzzz!
                        </div>
                        <a href="<?php echo e(route('orders.reorder', $order->order_number)); ?>" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-repeat me-2"></i> Pesan Lagi
                        </a>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($order->status == 'cancelled'): ?>
                    <div class="mt-4">
                        <div class="alert alert-warning">
                            <i class="bi bi-x-octagon me-2"></i>
                            Pesanan ini telah dibatalkan.
                        </div>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-success w-100">
                            <i class="bi bi-cart-plus me-2"></i> Belanja Lagi
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    
    .timeline-item.active::before {
        background-color: #28a745;
    }
    
    .timeline-item.current .timeline-icon {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
    
    .timeline-item.active .timeline-content h6 {
        color: #28a745;
    }
    
    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: white;
        border: 2px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    
    .timeline-content {
        padding-bottom: 8px;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .breadcrumb-item a {
        color: #28a745;
        text-decoration: none;
    }
    
    /* Efek hover untuk tombol */
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/orders/show.blade.php ENDPATH**/ ?>