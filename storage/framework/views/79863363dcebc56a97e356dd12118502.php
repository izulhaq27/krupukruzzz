


<?php $__env->startSection('title', 'Hasil Lacak - ' . ($order->order_number ?? '')); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <?php if(isset($order) && $order): ?>
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Status Pengiriman Ditemukan</h4>
        </div>
        <div class="card-body">
            <!-- Informasi Pesanan -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Informasi Pesanan</h5>
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">No. Pesanan</th>
                            <td><?php echo e($order->order_number); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Order</th>
                            <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td class="fw-bold">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-<?php echo e($order->status_color); ?>">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6">
                    <h5>Informasi Pengiriman</h5>
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">Kurir</th>
                            <td><?php echo e(strtoupper($order->shipping_courier ?? 'JNE')); ?></td>
                        </tr>
                        <tr>
                            <th>No. Resi</th>
                            <td class="fw-bold"><?php echo e($order->tracking_number); ?></td>
                        </tr>
                        <tr>
                            <th>Layanan</th>
                            <td><?php echo e($order->shipping_service ?? 'Reguler'); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Dikirim</th>
                            <td>
                                <?php if($order->shipped_at): ?>
                                    <?php echo e($order->shipped_at->format('d/m/Y')); ?>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Estimasi Tiba</th>
                            <td>
                                <?php if($order->estimated_delivery): ?>
                                    <?php echo e($order->estimated_delivery->format('d/m/Y')); ?>

                                <?php else: ?>
                                    <span class="text-muted">3-5 hari kerja</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a href="<?php echo e($order->tracking_link); ?>" target="_blank" 
                   class="btn btn-success btn-lg me-3">
                    <i class="bi bi-truck"></i> Lacak di Website Kurir
                </a>
                
                <a href="<?php echo e(route('tracking.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i> Cek Resi Lain
                </a>
            </div>
            
            <!-- Progress Tracking (Opsional) -->
            <?php if(in_array($order->status, ['shipped', 'delivered'])): ?>
            <div class="mt-5">
                <h5>Progress Pengiriman</h5>
                <div class="progress-tracking mt-3">
                    <?php
                        $steps = [
                            'pending' => ['Pending', 'Menunggu pembayaran'],
                            'paid' => ['Paid', 'Pembayaran diterima'],
                            'processing' => ['Processing', 'Pesanan diproses'],
                            'shipped' => ['Shipped', 'Pesanan dikirim'],
                            'delivered' => ['Delivered', 'Pesanan diterima']
                        ];
                    ?>
                    
                    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="tracking-step <?php echo e($order->status == $key ? 'active' : ''); ?>">
                        <div class="step-icon">
                            <?php if($order->status == $key): ?>
                                <i class="bi bi-check-circle-fill"></i>
                            <?php else: ?>
                                <i class="bi bi-circle"></i>
                            <?php endif; ?>
                        </div>
                        <div class="step-info">
                            <div class="step-title"><?php echo e($step[0]); ?></div>
                            <div class="step-desc"><?php echo e($step[1]); ?></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-danger text-center">
        <h4><i class="bi bi-exclamation-triangle"></i> Resi Tidak Ditemukan</h4>
        <p>Nomor resi atau email yang Anda masukkan tidak sesuai.</p>
        <a href="<?php echo e(route('tracking.index')); ?>" class="btn btn-primary">
            ← Kembali ke Form Pencarian
        </a>
    </div>
    <?php endif; ?>
</div>

<style>
.progress-tracking {
    border-left: 3px solid #dee2e6;
    margin-left: 15px;
    padding-left: 25px;
}
.tracking-step {
    position: relative;
    margin-bottom: 25px;
}
.tracking-step.active .step-icon {
    color: #28a745;
}
.step-icon {
    position: absolute;
    left: -33px;
    top: 0;
    font-size: 1.5rem;
    background: white;
}
.step-title {
    font-weight: bold;
    margin-bottom: 2px;
}
.step-desc {
    font-size: 0.9rem;
    color: #6c757d;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/tracking/result.blade.php ENDPATH**/ ?>