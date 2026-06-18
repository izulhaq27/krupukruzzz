<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="<?php echo e(route('products.index')); ?>" class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">Beranda</a>
            </li>
            <li class="flex items-center space-x-2">
                <i class="bi bi-chevron-right text-[10px] text-slate-400"></i>
                <a href="<?php echo e(route('products.index')); ?>" class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">Produk</a>
            </li>
            <li class="flex items-center space-x-2" aria-current="page">
                <i class="bi bi-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-800 font-bold"><?php echo e(Str::limit($product->name, 20)); ?></span>
            </li>
        </ol>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        <!-- Product Image Section -->
        <div class="lg:w-1/2">
            <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 flex items-center justify-center min-h-[350px] shadow-sm animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards] sticky top-24">
                <?php if($product->image): ?>
                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                         class="w-full h-full max-h-[500px] object-contain drop-shadow-xl rounded-2xl" 
                         alt="<?php echo e($product->name); ?>"
                         fetchpriority="high"
                         decoding="async">
                <?php else: ?>
                    <div class="text-center py-16">
                        <i class="bi bi-image text-7xl text-slate-200"></i>
                        <p class="mt-4 text-slate-400">Gambar tidak tersedia</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Product Info Section -->
        <div class="lg:w-1/2 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]" style="animation-delay: 0.1s;">
            <div class="lg:pl-4">
                <!-- Badges & Status -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="inline-flex items-center bg-emerald-50 text-emerald-600 border border-emerald-100 px-3 py-1 rounded-full text-xs font-semibold">
                             <?php echo e($category->name); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($product->stock > 0): ?>
                        <span class="inline-flex items-center bg-emerald-50/50 text-emerald-600 border border-emerald-500/20 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="bi bi-check-circle-fill mr-1.5"></i> Stok Tersedia
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="bi bi-x-circle-fill mr-1.5"></i> Stok Habis
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Product Name -->
                <h1 class="font-extrabold text-3xl md:text-4xl lg:text-5xl text-slate-900 leading-tight tracking-tight mb-4">
                    <?php echo e($product->name); ?>

                </h1>

                <!-- Price Section -->
                <div class="mb-8">
                    <?php if($product->discount_price): ?>
                        <div class="flex items-center gap-4 mb-2">
                            <span class="font-extrabold text-3xl md:text-4xl text-emerald-500 tracking-tight">
                                Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?>

                            </span>
                            <span class="line-through text-slate-400 text-lg md:text-xl font-medium">
                                Rp<?php echo e(number_format($product->discount_price, 0, ',', '.')); ?>

                            </span>
                            <?php
                                $percent = round((($product->discount_price - $product->price) / $product->discount_price) * 100);
                            ?>
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">-<?php echo e($percent); ?>%</span>
                        </div>
                    <?php else: ?>
                        <span class="block font-extrabold text-3xl md:text-4xl text-emerald-500 tracking-tight mb-2">
                            Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?>

                        </span>
                    <?php endif; ?>
                    <p class="text-sm text-slate-500 flex items-center">
                        <i class="bi bi-box-seam mr-2 text-emerald-500"></i> Sisa stok: <strong class="text-slate-700 ml-1"><?php echo e($product->stock); ?> unit</strong>
                    </p>
                </div>

                <div class="h-px bg-slate-200 w-full my-8"></div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 mb-10">
                    <div class="sm:w-2/3">
                        <?php if($product->stock > 0): ?>
                            <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="redirect_to" value="cart">
                                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full flex justify-center items-center gap-2 shadow-sm shadow-emerald-500/20 transition-all duration-200 active:scale-95 text-lg">
                                    <i class="bi bi-bag-plus-fill text-xl"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        <?php else: ?>
                            <button disabled class="w-full bg-slate-200 text-slate-500 font-bold py-4 rounded-full flex justify-center items-center gap-2 cursor-not-allowed text-lg">
                                <i class="bi bi-dash-circle"></i> Stok Habis
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="hidden sm:block sm:w-1/3">
                        <button onclick="window.history.back()" class="w-full bg-white border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-bold py-4 rounded-full flex justify-center items-center gap-2 transition-all duration-200 active:scale-95 text-lg">
                             <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                    </div>
                </div>

                <!-- Product Description Box -->
                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden mb-8 shadow-sm">
                    <div class="border-b border-slate-100 px-6 pt-6 pb-4 bg-slate-50/50">
                        <h5 class="font-bold text-slate-800 m-0 flex items-center gap-2 text-lg">
                            <i class="bi bi-card-text text-emerald-500"></i> Deskripsi
                        </h5>
                    </div>
                    <div class="p-6">
                        <div class="text-slate-600 leading-relaxed text-sm whitespace-pre-line">
                            <?php if($product->description): ?>
                                <?php echo nl2br(e($product->description)); ?>

                            <?php else: ?>
                                <span class="italic">Tidak ada deskripsi untuk produk ini.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Trust Badges -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 flex justify-between shadow-sm">
                    <div class="text-center flex-1">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto mb-3">
                            <i class="bi bi-shield-check text-2xl"></i>
                        </div>
                        <span class="block font-semibold text-slate-700 text-xs">100% Asli</span>
                    </div>
                    <div class="text-center flex-1">
                        <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mx-auto mb-3">
                            <i class="bi bi-clock-history text-2xl"></i>
                        </div>
                        <span class="block font-semibold text-slate-700 text-xs">Selalu Baru</span>
                    </div>
                    <div class="text-center flex-1">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mx-auto mb-3">
                            <i class="bi bi-box-seam text-2xl"></i>
                        </div>
                        <span class="block font-semibold text-slate-700 text-xs">Aman</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/products/show.blade.php ENDPATH**/ ?>