

<?php $__env->startSection('content'); ?>
<!-- Hero Section (Static Visual Only) -->
<div class="container-fluid px-lg-5 mb-4"> <!-- FULL WIDTH with Padding -->
    <div class="rounded-4 p-4 p-lg-5 text-white position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%); min-height: 250px; display: flex; align-items: center;"> 
        
        <!-- Background Pattern/Image (Optional) -->
        <div style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; opacity: 0.1; background-image: url('https://www.transparenttextures.com/patterns/food.png');"></div>

        <div class="row align-items-center position-relative z-1 w-100">
            <div class="col-lg-7 col-12 text-start">
                <!-- Responsive Typography: Display-4 for desktop, smaller for mobile -->
                <h1 class="fw-bold display-4 d-none d-lg-block mb-2">Selamat Datang di KrupuKruzzz</h1>
                <h1 class="fw-bold fs-2 d-lg-none mb-2">Selamat Datang di KrupuKruzzz</h1>
                
                <p class="lead mb-4 opacity-90 fs-6 fs-lg-5">Solusi camilan kerupuk berkualitas, gurih, dan harga bersahabat.</p>
                
                <a href="#produk-list" class="btn btn-light text-success fw-bold px-5 py-3 rounded-pill shadow-sm transition-hover">
                    Belanja Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            
            <!-- Abstract Elements / Bintik-bintik on Desktop Only -->
            <div class="col-lg-5 d-none d-lg-block text-end position-relative">
                 <!-- Element 1: Big Dotted Circle -->
                 <div class="position-absolute" 
                      style="top: -60px; right: 20px; width: 180px; height: 180px; border: 4px dotted rgba(255,255,255,0.3); border-radius: 50%;"></div>
                 
                 <!-- Element 2: Small Dashed Circle -->
                 <div class="position-absolute" 
                      style="bottom: -40px; right: 100px; width: 120px; height: 120px; border: 3px dashed rgba(255,255,255,0.2); border-radius: 50%;"></div>
                 
                 <!-- Element 3: Abstract Shape (Kerupuk-like) -->
                 <div class="position-absolute" 
                      style="top: 20px; right: 80px; width: 60px; height: 60px; background: rgba(255,255,255,0.15); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: rotate(45deg);"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover { transition: transform 0.2s; }
    .transition-hover:hover { transform: translateY(-3px); }
</style>

<div class="container-fluid px-lg-5 my-4" id="produk-list"> <!-- FULL WIDTH -->

    <!-- Section Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-dark m-0">
            <span style="border-left: 4px solid var(--primary-green); padding-left: 10px;">Rekomendasi Produk</span>
        </h4>
    </div>

    <div class="row g-2 g-md-3"> <!-- Smaller Gap for Mobile -->
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- GRID ADJUSTMENT: col-4 for mobile (3 items) as requested, or col-6 (2 items) -->
        <!-- User asked for "3 baris" (3 rows/lines/cols?). Assuming 3 Columns for "card" -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-4"> 
            <div class="card product-card h-100 bg-white" style="border: 1px solid #f0f0f0;">
                
                <!-- Position Relative for Badge -->
                <div class="position-relative">
                    <!-- FOTO -->
                    <div style="width: 100%; aspect-ratio: 1/1; overflow: hidden; background: #f8f9fa;">
                        <?php if($product->image && file_exists(public_path('storage/'.$product->image))): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>"
                                 class="w-100 h-100"
                                 style="object-fit: cover;"
                                 alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex justify-content-center align-items-center text-muted">
                                <i class="bi bi-image fs-1 opacity-25"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CARD BODY -->
                <div class="card-body p-3 d-flex flex-column">
                    <!-- Categories -->
                    <div class="mb-2">
                        <?php $__currentLoopData = $product->categories->take(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.7rem;"><?php echo e($cat->name); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <h6 class="card-title fw-semibold text-dark mb-1 text-truncate"><?php echo e($product->name); ?></h6>
                    
                    <div class="d-flex align-items-baseline mb-2">
                        <span class="fw-bold" style="color: var(--primary-green); font-size: 1.1rem;">
                            Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                        </span>
                        <?php if($product->discount_price): ?>
                            <small class="text-decoration-line-through text-muted ms-2" style="font-size: 0.8rem;">
                                Rp <?php echo e(number_format($product->discount_price, 0, ',', '.')); ?>

                            </small>
                        <?php endif; ?>
                    </div>



                    <!-- BUTTONS -->
                    <div class="mt-auto d-grid gap-2">
                        <?php if($product->stock > 0): ?>
                            <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="redirect_to" value="cart">
                                <button type="submit" class="btn btn-outline-success btn-sm w-100 fw-medium">
                                    <i class="bi bi-cart-plus me-1"></i> + Keranjang
                                </button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-light btn-sm w-100 text-muted" disabled>Stok Habis</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($products->isEmpty()): ?>
        <div class="text-center py-5">
            <div class="opacity-25 mb-3">
                <i class="bi bi-search display-1 text-secondary"></i>
            </div>
            <h5 class="text-muted">Produk belum tersedia</h5>
        </div>
    <?php endif; ?>

</div>

<style>
    /* Hero Hover Effect */
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        border-color: transparent !important;
    }
    
    .product-card:hover img {
        transform: scale(1.05);
    }
    
    .btn-outline-success {
        color: var(--primary-green);
        border-color: var(--primary-green);
    }
    
    .btn-outline-success:hover {
        background-color: var(--primary-green);
        color: white;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/products/index.blade.php ENDPATH**/ ?>