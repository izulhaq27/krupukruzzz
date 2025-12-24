

<?php $__env->startSection('title', 'Checkout Berhasil'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    <!-- Icon Success -->
                    <div class="mb-4">
                        <div style="
                            width: 80px;
                            height: 80px;
                            background: #28a745;
                            border-radius: 50%;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-size: 2rem;
                        ">
                            ✓
                        </div>
                    </div>
                    
                    <h1 class="fw-bold mb-3" style="color: #28a745;">
                        Checkout Berhasil!
                    </h1>
                    
                    <p class="text-muted mb-4">
                        Terima kasih telah berbelanja di toko kami. Pesanan Anda sedang diproses.
                    </p>
                    
                    <!-- Order Summary -->
                    <div class="card mb-4" style="background: #f8f9fa;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">📋 Detail Pesanan</h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Nomor Order</th>
                                    <td><strong><?php echo e($order->order_number); ?></strong></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td><?php echo e($order->created_at->format('d F Y H:i')); ?></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td class="fw-bold" style="color: #28a745;">
                                        Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-<?php echo e($order->status == 'pending' ? 'warning' : 'success'); ?>">
                                            <?php echo e(strtoupper($order->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Customer Info -->
                    <div class="card mb-4" style="background: #f8f9fa;">
                        <div class="card-body">
                            <h5 class="card-title mb-3">👤 Informasi Pengiriman</h5>
                            
                            <table class="table table-borderless">
                                <tr>
                                    <th width="120">Nama</th>
                                    <td><?php echo e($order->name); ?></td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td><?php echo e($order->phone); ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?php echo e($order->address); ?>, <?php echo e($order->city); ?>, <?php echo e($order->province); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary px-4">
                            <i class="bi bi-shop"></i> Lanjut Belanja
                        </a>
                        
                        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-primary px-4">
                            <i class="bi bi-list-check"></i> Lihat Pesanan Saya
                        </a>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted small mb-2">
                            <i class="bi bi-info-circle"></i>
                            Anda akan menerima email konfirmasi ke <strong><?php echo e($order->email); ?></strong>
                        </p>
                        <p class="text-muted small">
                            Untuk pertanyaan, hubungi kami di <strong>0812-3456-7890</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .table th {
        font-weight: 500;
        color: #6c757d;
    }
    
    .btn {
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/checkout/success.blade.php ENDPATH**/ ?>