

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 fw-bold text-success mb-2">
                        <i class="bi bi-box-seam"></i> Pesanan Saya
                    </h1>
                    <p class="text-muted mb-0">Kelola dan lacak semua pesanan Anda di sini</p>
                </div>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Belanja Lagi
                </a>
            </div>

            <!-- FILTER STATUS -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo e(route('orders.index')); ?>" 
                           class="btn btn-outline-secondary <?php echo e(!request('status') ? 'active' : ''); ?>">
                            Semua (<?php echo e(auth()->user()->orders()->count()); ?>)
                        </a>
                        <a href="<?php echo e(route('orders.index', ['status' => 'pending'])); ?>" 
                           class="btn btn-outline-warning <?php echo e(request('status') == 'pending' ? 'active' : ''); ?>">
                            Menunggu Bayar (<?php echo e(auth()->user()->pendingOrders()->count()); ?>)
                        </a>
                        <a href="<?php echo e(route('orders.index', ['status' => 'processed'])); ?>" 
                           class="btn btn-outline-primary <?php echo e(request('status') == 'processed' ? 'active' : ''); ?>">
                            Diproses (<?php echo e(auth()->user()->orders()->where('status', 'processed')->count()); ?>)
                        </a>
                        <a href="<?php echo e(route('orders.index', ['status' => 'shipped'])); ?>" 
                           class="btn btn-outline-info <?php echo e(request('status') == 'shipped' ? 'active' : ''); ?>">
                            Dikirim (<?php echo e(auth()->user()->orders()->where('status', 'shipped')->count()); ?>)
                        </a>
                        <a href="<?php echo e(route('orders.index', ['status' => 'completed'])); ?>" 
                           class="btn btn-outline-success <?php echo e(request('status') == 'completed' ? 'active' : ''); ?>">
                            Selesai (<?php echo e(auth()->user()->completedOrders()->count()); ?>)
                        </a>
                    </div>
                </div>
            </div>

            <!-- LIST PESANAN -->
            <?php if($orders->count() > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow">
                            <div class="card-body">
                                <!-- HEADER PESANAN -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-uppercase small text-muted">
                                            <i class="bi bi-receipt"></i> NO. PESANAN
                                        </h6>
                                        <h5 class="fw-bold mb-0"><?php echo e($order->order_number); ?></h5>
                                    </div>
                                    <div class="text-end">
                                        <h6 class="fw-bold mb-1 text-uppercase small text-muted">
                                            TANGGAL
                                        </h6>
                                        <p class="mb-0"><?php echo e($order->created_at->format('d/m/Y')); ?></p>
                                    </div>
                                </div>

                                <!-- STATUS -->
                                <div class="mb-3">
                                    <?php
                                        $statusConfig = [
                                            'pending' => ['color' => 'warning', 'icon' => 'clock', 'label' => 'Menunggu Pembayaran'],
                                            'paid' => ['color' => 'info', 'icon' => 'check-circle', 'label' => 'Dibayar'],
                                            'processed' => ['color' => 'primary', 'icon' => 'gear', 'label' => 'Diproses'],
                                            'shipped' => ['color' => 'success', 'icon' => 'truck', 'label' => 'Dikirim'],
                                            'completed' => ['color' => 'dark', 'icon' => 'check2-circle', 'label' => 'Selesai'],
                                            'cancelled' => ['color' => 'danger', 'icon' => 'x-circle', 'label' => 'Dibatalkan'],
                                            'failed' => ['color' => 'danger', 'icon' => 'exclamation-triangle', 'label' => 'Gagal'],
                                        ];
                                        $config = $statusConfig[$order->status] ?? ['color' => 'secondary', 'icon' => 'question', 'label' => $order->status];
                                    ?>
                                    
                                    <span class="badge bg-<?php echo e($config['color']); ?> px-3 py-2 mb-2">
                                        <i class="bi bi-<?php echo e($config['icon']); ?> me-1"></i> <?php echo e($config['label']); ?>

                                    </span>
                                </div>

                                <!-- INFO PENGIRIMAN -->
                                <?php if($order->shipping_courier): ?>
                                <div class="border-top pt-3 mb-3">
                                    <h6 class="fw-bold text-muted small mb-2">
                                        <i class="bi bi-truck"></i> INFO PENGIRIMAN
                                    </h6>
                                    <div class="row g-2">
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
                                                <code class="me-2"><?php echo e($order->tracking_number); ?></code>
                                                <?php if($order->tracking_link): ?>
                                                <a href="<?php echo e($order->tracking_link); ?>" target="_blank" 
                                                   class="btn btn-sm btn-outline-info py-0">
                                                    <i class="bi bi-box-arrow-up-right"></i> Lacak
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- ITEMS -->
                                <div class="border-top pt-3 mb-3">
                                    <h6 class="fw-bold text-muted small mb-2">
                                        <i class="bi bi-cart"></i> ITEM PESANAN
                                    </h6>
                                    <?php if($order->items && $order->items->count() > 0): ?>
                                        <ul class="list-unstyled mb-0">
                                            <?php $__currentLoopData = $order->items->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="d-flex justify-content-between mb-1">
                                                    <span><?php echo e($item->product_name ?? 'Produk'); ?> × <?php echo e($item->quantity); ?></span>
                                                    <span>Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($order->items->count() > 2): ?>
                                                <li class="text-muted small">
                                                    + <?php echo e($order->items->count() - 2); ?> item lainnya
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-muted small mb-0">Tidak ada detail item</p>
                                    <?php endif; ?>
                                </div>

                                <!-- TOTAL & AKSI -->
                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block">TOTAL</small>
                                            <h4 class="fw-bold text-success mb-0">
                                                Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>

                                            </h4>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo e(route('orders.show', $order->order_number)); ?>" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <?php if($order->status == 'shipped'): ?>
                                                <a href="<?php echo e($order->tracking_link ?? '#'); ?>" target="_blank"
                                                   class="btn btn-success btn-sm">
                                                    <i class="bi bi-truck"></i> Lacak
                                                </a>
                                            <?php endif; ?>
                                            <?php if(in_array($order->status, ['cancelled', 'failed'])): ?>
                                                <form action="<?php echo e(route('orders.destroy', $order->order_number)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pesanan ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- PAGINATION -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php else: ?>
                <!-- KOSONG -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-cart-x display-1 text-muted"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Belum Ada Pesanan</h4>
                    <p class="text-muted mb-4">Mulai berbelanja dan buat pesanan pertama Anda</p>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-shop"></i> Mulai Belanja
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .hover-shadow:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.15) !important;
        border-color: var(--primary-green);
    }
    
    .btn-outline-secondary.active,
    .btn-outline-warning.active,
    .btn-outline-primary.active,
    .btn-outline-info.active,
    .btn-outline-success.active {
        background-color: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
    }
    
    .card {
        border-radius: 12px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/orders/index.blade.php ENDPATH**/ ?>