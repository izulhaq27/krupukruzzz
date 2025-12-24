<!DOCTYPE html>
<html>
<head>
    <title>Detail Order #<?php echo e($order->order_number); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background: #f8f9fa; }
        .card { margin-bottom: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .btn-back { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Detail Order: <?php echo e($order->order_number); ?></h1>
        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">👤 Informasi Customer</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="120">Nama:</th>
                                <td><?php echo e($order->user->name ?? $order->name); ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?php echo e($order->user->email ?? $order->email); ?></td>
                            </tr>
                            <tr>
                                <th>Telepon:</th>
                                <td><?php echo e($order->phone); ?></td>
                            </tr>
                            <tr>
                                <th>Alamat:</th>
                                <td><?php echo e($order->address); ?>, <?php echo e($order->city); ?>, <?php echo e($order->province); ?> <?php echo e($order->postal_code); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">📋 Informasi Order</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="120">Status:</th>
                                <td>
                                    <span class="badge bg-<?php echo e($order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : 'success')); ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td class="fw-bold">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal:</th>
                                <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                            </tr>
                            <?php if($order->tracking_number): ?>
                            <tr>
                                <th>Resi:</th>
                                <td>
                                    <span class="badge bg-info"><?php echo e($order->tracking_number); ?></span>
                                    <small class="text-muted">(<?php echo e(strtoupper($order->shipping_courier)); ?>)</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Dikirim:</th>
                                <td><?php echo e($order->shipped_at->format('d/m/Y H:i')); ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FORM UPDATE RESI -->
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0">Update Resi Pengiriman</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.orders.update-tracking', $order->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nomor Resi *</label>
                                <input type="text" class="form-control" name="tracking_number" 
                                       value="<?php echo e(old('tracking_number', $order->tracking_number)); ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kurir *</label>
                                <select class="form-control" name="shipping_courier" required>
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne" <?php echo e($order->shipping_courier == 'jne' ? 'selected' : ''); ?>>JNE</option>
                                    <option value="tiki" <?php echo e($order->shipping_courier == 'tiki' ? 'selected' : ''); ?>>TIKI</option>
                                    <option value="pos" <?php echo e($order->shipping_courier == 'pos' ? 'selected' : ''); ?>>POS Indonesia</option>
                                    <option value="sicepat" <?php echo e($order->shipping_courier == 'sicepat' ? 'selected' : ''); ?>>SiCepat</option>
                                    <option value="jnt" <?php echo e($order->shipping_courier == 'jnt' ? 'selected' : ''); ?>>J&T</option>
                                    <option value="anteraja" <?php echo e($order->shipping_courier == 'anteraja' ? 'selected' : ''); ?>>AnterAja</option>
                                    <option value="ninja" <?php echo e($order->shipping_courier == 'ninja' ? 'selected' : ''); ?>>Ninja Xpress</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Layanan</label>
                                <input type="text" class="form-control" name="shipping_service" 
                                       value="<?php echo e(old('shipping_service', $order->shipping_service)); ?>"
                                       placeholder="REG, YES, OKE, dll">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <?php if($order->tracking_number): ?>
                            <i class="bi bi-pencil"></i> Update Resi
                        <?php else: ?>
                            <i class="bi bi-check"></i> Simpan Resi
                        <?php endif; ?>
                    </button>
                </form>
            </div>
        </div>
        
        <div class="d-flex justify-content-between mt-4 mb-5">
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary">
                ← Kembali ke Daftar Order
            </a>
            
            <a href="<?php echo e(route('admin.orders.print', $order->id)); ?>" target="_blank" class="btn btn-dark">
                <i class="bi bi-printer"></i> Cetak Invoice
            </a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>