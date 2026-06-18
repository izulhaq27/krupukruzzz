<?php $__env->startSection('content'); ?>
<!-- Category Header Banner -->
<div class="container-fluid px-lg-5 mb-4 animate-fade-in-up">
    <div class="rounded-4 p-4 p-md-5 text-white position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, var(--cm-primary) 0%, #064E3B 100%); min-height: 200px; display: flex; align-items: center;">
         
        <!-- Abstract Patterns -->
        <div style="position: absolute; top: -20px; right: 10%; width: 150px; height: 150px; border: 2px dashed rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -40px; right: -20px; width: 120px; height: 120px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div class="d-none d-md-block" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.05; background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="row align-items-center position-relative z-1 w-100">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3" style="font-size: 0.85rem;">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>" class="text-white text-decoration-none opacity-75">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('categories.index')); ?>" class="text-white text-decoration-none opacity-75">Kategori</a></li>
                        <li class="breadcrumb-item active text-white fw-bold" aria-current="page"><?php echo e($category->name); ?></li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <?php if($category->image): ?>
                        <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="rounded-circle shadow-sm border border-2 border-white bg-white" style="width: 64px; height: 64px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center shadow-sm" style="width: 64px; height: 64px; flex-shrink: 0;">
                            <i class="bi bi-tag-fill" style="font-size: 1.8rem; color: var(--cm-primary);"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h1 class="fw-bold mb-1" style="font-size: clamp(1.5rem, 3vw, 2.2rem);"><?php echo e($category->name); ?></h1>
                        <span class="badge bg-white text-primary rounded-pill px-2 py-1 fw-medium" style="font-size: 0.75rem;">
                            <?php echo e($category->products->count()); ?> Produk
                        </span>
                    </div>
                </div>
                <?php if($category->description): ?>
                    <p class="mb-0 mt-3 opacity-90" style="font-size: 0.95rem; max-width: 600px;"><?php echo e($category->description); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-lg-5 mb-5">
    <!-- Filter Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h5 class="fw-bold mb-0" style="color: var(--cm-neutral-800);">Koleksi Produk</h5>
        <div class="dropdown">
            <button class="btn btn-sm btn-cm-white border btn-cm-pill dropdown-toggle fw-medium text-secondary" type="button" data-bs-toggle="dropdown">
                Terbaru
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: var(--cm-radius-md);">
                <li><a class="dropdown-item active bg-primary text-white" href="#">Terbaru</a></li>
                <li><a class="dropdown-item" href="#">Harga Terendah</a></li>
                <li><a class="dropdown-item" href="#">Harga Tertinggi</a></li>
            </ul>
        </div>
    </div>

    <!-- Product Grid -->
    <?php if($category->products->count() > 0): ?>
        <div class="row g-2 g-md-3 justify-content-start">
            <?php $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-6 animate-fade-in-up" style="animation-delay: <?php echo e($loop->iteration * 0.05); ?>s;"> 
                <div class="card product-card h-100 border-0 overflow-hidden position-relative">
                    
                    <!-- Image -->
                    <div class="position-relative overflow-hidden">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="d-block">
                            <div class="ratio ratio-1x1" style="background: var(--cm-neutral-50);">
                                <?php if($product->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>"
                                         class="w-100 h-100"
                                         style="object-fit: cover; transition: transform 0.5s var(--cm-ease);"
                                         alt="<?php echo e($product->name); ?>"
                                         loading="lazy"
                                         decoding="async">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex justify-content-center align-items-center" style="color: var(--cm-neutral-300);">
                                        <i class="bi bi-image fs-1"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-2 p-md-3 d-flex flex-column">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="text-decoration-none mb-1">
                            <h6 class="fw-bold mb-0 text-truncate" style="font-size: 0.88rem; color: var(--cm-neutral-800); letter-spacing: -0.01em;">
                                <?php echo e($product->name); ?>

                            </h6>
                        </a>
                        
                        <div class="mb-2">
                            <span class="fw-bold" style="color: var(--cm-primary); font-size: 1.05rem;">
                                Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?>

                            </span>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-auto d-flex gap-1 gap-md-2 align-items-center">
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                               class="btn d-flex align-items-center justify-content-center" 
                               style="width: 34px; height: 34px; flex-shrink: 0; background: var(--cm-neutral-100); color: var(--cm-neutral-500); border: none; border-radius: var(--cm-radius-sm);"
                               title="Detail Produk">
                                <i class="bi bi-arrow-right" style="font-size: 0.9rem;"></i>
                            </a>
                            <?php if($product->stock > 0): ?>
                                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="flex-grow-1">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="redirect_to" value="cart">
                                    <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-1 py-1 shadow-sm" 
                                            style="border-radius: var(--cm-radius-sm); font-size: clamp(0.68rem, 2vw, 0.82rem); height: 34px;">
                                        <i class="bi bi-bag-plus d-none d-md-inline" style="font-size: 0.8rem;"></i>
                                        <span class="text-nowrap fw-bold">Beli</span>
                                    </button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary flex-grow-1 py-1 disabled" style="border-radius: var(--cm-radius-sm); font-size: 0.75rem; height: 34px; opacity: 0.5;">
                                    Habis
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5 cm-card animate-fade-in-up" style="border-radius: var(--cm-radius-xl);">
            <div class="mb-4">
                <i class="bi bi-box-seam display-1" style="color: var(--cm-neutral-200);"></i>
            </div>
            <h4 class="fw-bold" style="color: var(--cm-neutral-800);">Belum Ada Produk</h4>
            <p style="color: var(--cm-neutral-500); max-width: 400px; margin: 0 auto 1.5rem;">Tidak ada produk dalam kategori ini saat ini.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-cm-primary-outline btn-cm-pill px-4 py-2">
                Lihat Kategori Lain
            </a>
        </div>
    <?php endif; ?>

    <!-- Related Categories -->
    <?php if($relatedCategories->count() > 0): ?>
    <div class="mt-5 pt-4 border-top animate-fade-in-up" style="animation-delay: 0.2s;">
        <h5 class="fw-bold mb-4" style="color: var(--cm-neutral-800);">Kategori Lainnya</h5>
        <div class="d-flex gap-3 overflow-x-auto custom-scrollbar pb-3 px-1">
            <?php $__currentLoopData = $relatedCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('categories.show', $related->slug)); ?>" class="text-decoration-none flex-shrink-0" style="width: 140px;">
                <div class="cm-card p-3 text-center h-100 transition-all related-card" style="border-radius: var(--cm-radius-lg);">
                    <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" 
                         style="width: 48px; height: 48px; background: var(--cm-primary-subtle); color: var(--cm-primary);">
                        <i class="bi bi-tag-fill fs-5"></i>
                    </div>
                    <h6 class="fw-bold mb-1 text-truncate" style="font-size: 0.85rem; color: var(--cm-neutral-800);"><?php echo e($related->name); ?></h6>
                    <small style="color: var(--cm-neutral-500); font-size: 0.75rem;"><?php echo e($related->products_count); ?> Produk</small>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }
    
    .related-card {
        border: 1px solid var(--cm-neutral-100);
        background: var(--cm-white);
    }
    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--cm-shadow-md) !important;
        border-color: var(--cm-primary-subtle) !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/categories/show.blade.php ENDPATH**/ ?>