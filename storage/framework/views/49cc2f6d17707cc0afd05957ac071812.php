

<?php $__env->startSection('content'); ?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Produk</a></li>
            <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
        </ol>
    </nav>

    <div class="row">
        
        <div class="col-md-6 mb-4">
            <?php if($product->image): ?>
                <?php if(str_starts_with($product->image, 'http')): ?>
                    <img src="<?php echo e($product->image); ?>" class="img-fluid rounded shadow" alt="<?php echo e($product->name); ?>">
                <?php else: ?>
                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" class="img-fluid rounded shadow" alt="<?php echo e($product->name); ?>">
                <?php endif; ?>
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded shadow" style="height: 400px;">
                    <div class="text-center">
                        <h1 class="display-1"></h1>
                        <h3><?php echo e($product->name); ?></h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="col-md-6">
            <h1 class="fw-bold mb-3"><?php echo e($product->name); ?></h1>
            <span class="badge bg-success mb-3">Tersedia</span>
            
            <h2 class="text-danger mb-3">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></h2>
            <p class="text-muted mb-4">
                <strong>Stok:</strong> <?php echo e($product->stock); ?> unit
            </p>
            
            <hr>
            
            <h5 class="fw-bold mb-3">Deskripsi Produk</h5>
            <p class="text-muted"><?php echo e($product->description); ?></p>
            
            <div class="d-grid gap-2 mt-4">
                <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Tambah ke Keranjang
                    </button>
                </form>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary btn-lg">
                    Kembali ke Produk
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/products/show.blade.php ENDPATH**/ ?>