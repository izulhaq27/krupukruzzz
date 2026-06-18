<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
    <div class="rounded-3xl p-6 md:p-10 lg:p-12 text-white relative overflow-hidden flex items-center min-h-[260px]" 
         style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 60%, #064E3B 100%);">
        
        <!-- Decorative Elements -->
        <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full"></div>
        <div class="absolute -bottom-16 right-24 w-40 h-40 bg-white/5 rounded-full"></div>
        <div class="absolute top-8 right-48 w-16 h-16 bg-white/10 rounded-[30%_70%_70%_30%/30%_30%_70%_70%] rotate-45"></div>
        <div class="absolute bottom-5 -left-5 w-24 h-24 border-2 border-dashed border-white/10 rounded-full"></div>
        
        <!-- Dot Pattern -->
        <div class="hidden lg:block absolute top-0 right-0 bottom-0 w-2/5 opacity-5" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 items-center relative z-10 w-full gap-8">
            <div class="col-span-1 lg:col-span-7 text-left">
                <span class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-1.5 rounded-full mb-4 text-xs font-semibold backdrop-blur-sm border border-white/10">
                    <i class="bi bi-stars"></i> Premium Snack Boutique
                </span>
                <h1 class="hidden lg:block font-extrabold mb-4 text-4xl lg:text-5xl leading-tight tracking-tight">Selamat Datang di<br>KrupuKruzzz</h1>
                <h1 class="lg:hidden font-extrabold mb-3 text-3xl leading-snug">Selamat Datang di KrupuKruzzz</h1>
                
                <p class="mb-6 text-white/90 text-sm md:text-base max-w-md">Solusi camilan kerupuk berkualitas, gurih, renyah, dan harga bersahabat.</p>
                
                <a href="#produk-list" class="inline-flex items-center gap-2 bg-white text-emerald-600 hover:bg-emerald-50 hover:shadow-lg px-6 py-3 rounded-full font-bold text-sm transition-all duration-200 active:scale-95">
                    Belanja Sekarang <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            
            <!-- Abstract Elements - Desktop -->
            <div class="hidden lg:block col-span-5 text-right relative h-full min-h-[200px]">
                <div class="absolute -top-12 right-4 w-44 h-44 border-4 border-dotted border-white/20 rounded-full"></div>
                <div class="absolute -bottom-8 right-20 w-28 h-28 border-2 border-dashed border-white/10 rounded-full"></div>
                <div class="absolute top-4 right-16 w-12 h-12 bg-white/10 rounded-[30%_70%_70%_30%/30%_30%_70%_70%] rotate-45"></div>
            </div>
        </div>
    </div>
</div>

<!-- Kategori Populer (Horizontal Chips Marquee) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
    <div class="relative overflow-hidden">
        <div class="flex gap-3 py-1 w-max animate-[marquee_30s_linear_infinite] hover:[animation-play-state:paused]">
            <?php
                $categories = \App\Models\Category::withCount('products')->get();
            ?>
            
            
            <a href="<?php echo e(route('products.index')); ?>" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-xs whitespace-nowrap bg-emerald-500 text-white border border-emerald-500 transition-colors">
                <i class="bi bi-stars"></i> Semua Produk
            </a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('categories.show', $cat->slug)); ?>" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-medium text-xs whitespace-nowrap bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200 transition-colors">
                <i class="bi bi-tag"></i> <?php echo e($cat->name); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <a href="<?php echo e(route('products.index')); ?>" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-xs whitespace-nowrap bg-emerald-500 text-white border border-emerald-500 transition-colors" aria-hidden="true">
                <i class="bi bi-stars"></i> Semua Produk
            </a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('categories.show', $cat->slug)); ?>" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-medium text-xs whitespace-nowrap bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200 transition-colors" aria-hidden="true">
                <i class="bi bi-tag"></i> <?php echo e($cat->name); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <a href="<?php echo e(route('products.index')); ?>" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-xs whitespace-nowrap bg-emerald-500 text-white border border-emerald-500 transition-colors" aria-hidden="true">
                <i class="bi bi-stars"></i> Semua Produk
            </a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('categories.show', $cat->slug)); ?>" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-medium text-xs whitespace-nowrap bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200 transition-colors" aria-hidden="true">
                <i class="bi bi-tag"></i> <?php echo e($cat->name); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <a href="<?php echo e(route('products.index')); ?>" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-xs whitespace-nowrap bg-emerald-500 text-white border border-emerald-500 transition-colors" aria-hidden="true">
                <i class="bi bi-stars"></i> Semua Produk
            </a>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('categories.show', $cat->slug)); ?>" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-medium text-xs whitespace-nowrap bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200 transition-colors" aria-hidden="true">
                <i class="bi bi-tag"></i> <?php echo e($cat->name); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="absolute top-0 bottom-0 left-0 w-16 bg-gradient-to-r from-slate-50 to-transparent pointer-events-none z-10"></div>
        <div class="absolute top-0 bottom-0 right-0 w-16 bg-gradient-to-l from-slate-50 to-transparent pointer-events-none z-10"></div>
    </div>
</div>

<style>
    @keyframes marquee {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-25%); }
    }
</style>

<!-- Product Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-6" id="produk-list">
    <!-- Section Header -->
    <div class="flex justify-between items-center mb-4 px-1">
        <h4 class="font-bold m-0 flex items-center gap-2 text-slate-900 text-xl tracking-tight">
            <span class="w-1 h-6 bg-emerald-500 rounded-sm inline-block"></span>
            Rekomendasi Produk
        </h4>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 lg:gap-6">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="opacity-0 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]" style="animation-delay: <?php echo e($loop->iteration * 0.08); ?>s;">
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden relative flex flex-col h-full transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-100 active:scale-98 group">
                <!-- Image -->
                <div class="relative overflow-hidden aspect-square bg-slate-50">
                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block h-full">
                        <?php if($product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 alt="<?php echo e($product->name); ?>"
                                 loading="lazy">
                        <?php else: ?>
                            <div class="w-full h-full flex justify-center items-center text-slate-300">
                                <i class="bi bi-image text-4xl"></i>
                            </div>
                        <?php endif; ?>
                    </a>
                    
                    <!-- Category Badge -->
                    <?php if($product->categories->isNotEmpty()): ?>
                        <div class="absolute top-2 left-2 z-10">
                            <span class="bg-white/90 backdrop-blur-sm text-emerald-600 shadow-sm px-2.5 py-1 rounded-full text-[10px] font-semibold border border-white/20">
                                <?php echo e($product->categories->first()->name); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Card Body -->
                <div class="p-3 sm:p-4 flex flex-col flex-grow">
                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="mb-1 block">
                        <h6 class="font-bold text-sm text-slate-800 tracking-tight line-clamp-2 leading-snug group-hover:text-emerald-600 transition-colors">
                            <?php echo e($product->name); ?>

                        </h6>
                    </a>

                    <div class="mb-3">
                        <span class="font-bold text-emerald-500 text-lg">
                            Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?>

                        </span>
                    </div>

                    <div class="mt-auto flex gap-2 items-center">
                        <!-- Detail Button -->
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                           class="flex items-center justify-center w-9 h-9 shrink-0 bg-slate-100 text-slate-500 rounded-lg hover:bg-slate-200 hover:text-slate-700 transition-colors"
                           title="Detail Produk">
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        <!-- Buy Button -->
                        <?php if($product->stock > 0): ?>
                            <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="grow">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="redirect_to" value="cart">
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center gap-1.5 h-9 rounded-lg shadow-sm shadow-emerald-500/20 font-bold text-[11px] sm:text-xs transition-colors active:scale-95" title="Beli Sekarang">
                                    <i class="bi bi-bag-plus hidden sm:inline text-sm"></i>
                                    <span>Beli</span>
                                </button>
                            </form>
                        <?php else: ?>
                            <button disabled class="grow bg-slate-200 text-slate-500 h-9 rounded-lg text-[11px] sm:text-xs font-semibold cursor-not-allowed">
                                Habis
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($products->isEmpty()): ?>
        <div class="text-center py-16 px-4 bg-white rounded-3xl border border-slate-100 mt-6">
            <div class="text-slate-200 mb-4">
                <i class="bi bi-search text-6xl"></i>
            </div>
            <h5 class="text-slate-500 font-semibold text-lg">Produk belum tersedia</h5>
            <p class="text-slate-400 text-sm mt-1">Nantikan produk terbaru dari kami!</p>
        </div>
    <?php endif; ?>
</div>

<!-- Promo Banner -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-10">
    <div class="rounded-3xl p-8 md:p-12 text-center text-white shadow-xl shadow-amber-500/10" style="background: linear-gradient(135deg, var(--color-secondary), #EA580C);">
        <div class="mb-4 text-white/90">
            <i class="bi bi-gift-fill text-5xl"></i>
        </div>
        <h3 class="font-extrabold text-2xl mb-3 tracking-tight">Promo Member Baru!</h3>
        <p class="text-white/90 text-sm max-w-md mx-auto mb-6 leading-relaxed">Dapatkan diskon 15% untuk pembelian pertama Anda dengan mendaftar akun sekarang.</p>
        <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center gap-2 bg-white text-amber-600 hover:bg-amber-50 hover:shadow-lg px-6 py-3 rounded-full font-bold text-sm transition-all duration-200 active:scale-95">
            <i class="bi bi-person-plus"></i> Daftar Sekarang
        </a>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/products/index.blade.php ENDPATH**/ ?>