

<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h1 class="mb-4">🛒 Checkout</h1>
    
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>
    
    <?php if(empty($cart)): ?>
        <div class="alert alert-warning">
            Keranjang Anda kosong! 
            <a href="<?php echo e(route('products.index')); ?>">Belanja dulu</a>
        </div>
    <?php else: ?>
        <form action="<?php echo e(route('checkout.process')); ?>" method="POST" id="checkout-form">
            <?php echo csrf_field(); ?>
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Cart Summary -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Ringkasan Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item['name']); ?></td>
                                        <td>Rp <?php echo e(number_format($item['price'], 0, ',', '.')); ?></td>
                                        <td><?php echo e($item['quantity']); ?></td>
                                        <td>Rp <?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th>Rp <?php echo e(number_format($total, 0, ',', '.')); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Data Diri -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">👤 Data Diri</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo e(old('name', auth()->user()->name ?? '')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon *</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               value="<?php echo e(old('phone', auth()->user()->phone ?? '')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo e(old('email', auth()->user()->email ?? '')); ?>" required>
                                        <small class="text-muted">Invoice dan info pengiriman akan dikirim ke email ini</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="fas fa-info-circle"></i>
                                Data ini akan digunakan untuk pengiriman dan kontak.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Address Form -->
                    <div class="card">
                        <div class="card-header">
                            <h5>📍 Alamat Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Penerima *</label>
                                <input type="text" name="shipping_name" class="form-control" 
                                       value="<?php echo e(old('shipping_name', auth()->user()->name ?? '')); ?>" required>
                                <small class="text-muted">Nama penerima paket</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap *</label>
                                <textarea name="address" class="form-control" rows="3" required><?php echo e(old('address', auth()->user()->address ?? '')); ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Kota *</label>
                                        <input type="text" name="city" class="form-control" 
                                               value="<?php echo e(old('city', auth()->user()->city ?? '')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Provinsi *</label>
                                        <input type="text" name="province" class="form-control" 
                                               value="<?php echo e(old('province', auth()->user()->province ?? '')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Kode Pos *</label>
                                        <input type="text" name="postal_code" class="form-control" 
                                               value="<?php echo e(old('postal_code', auth()->user()->postal_code ?? '')); ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Order Summary -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Total Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkir:</span>
                                <span>Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong class="text-primary">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></strong>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Info -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6><i class="fas fa-shield-alt"></i> Pembayaran Aman</h6>
                            <p class="small text-muted mb-0">
                                Pembayaran diproses melalui Midtrans dengan enkripsi SSL.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-lock"></i> Lanjutkan ke Pembayaran
                            </button>
                            <p class="text-muted small mt-2 mb-0">
                                Dengan mengklik tombol ini, Anda menyetujui 
                                <a href="#">Syarat & Ketentuan</a> kami.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<style>
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
        padding: 1rem 1.25rem;
    }
    
    .card-header h5 {
        margin: 0;
        color: #333;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/checkout/index.blade.php ENDPATH**/ ?>