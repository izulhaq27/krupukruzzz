<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="text-center mb-10 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
        <span class="inline-flex items-center gap-2 bg-white border border-slate-200 shadow-sm px-4 py-2 rounded-full text-xs font-semibold text-emerald-600 mb-4">
            <i class="bi bi-grid-fill"></i> Jelajahi Kategori
        </span>
        <h2 class="font-extrabold text-3xl md:text-4xl text-slate-900 tracking-tight mb-3">Pilih Sesuai Selera</h2>
        <p class="text-slate-500 max-w-md mx-auto leading-relaxed">
            Temukan berbagai jenis kerupuk renyah yang sesuai dengan selera Anda. Dari yang gurih hingga pedas, semuanya ada di sini.
        </p>
    </div>

    <!-- Category Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        <?php if($categories->count() > 0): ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards] opacity-0" style="animation-delay: <?php echo e($loop->iteration * 0.08); ?>s;">
                <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="block h-full group">
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 text-center h-full hover:-translate-y-2 hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-100 transition-all duration-300">
                        <div class="relative inline-block mb-4">
                            <?php if($category->image): ?>
                                <img src="<?php echo e(asset('storage/' . $category->image)); ?>"
                                     alt="<?php echo e($category->name); ?>"
                                     class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md group-hover:scale-105 transition-transform duration-300">
                            <?php else: ?>
                                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto shadow-md border-4 border-white group-hover:scale-105 transition-transform duration-300"
                                     style="background: linear-gradient(135deg, #10B981, #34D399);">
                                    <i class="bi bi-tag-fill text-white text-3xl"></i>
                                </div>
                            <?php endif; ?>
                            <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-white rounded-full shadow-md flex items-center justify-center border-2 border-white">
                                <i class="bi bi-arrow-right text-emerald-500 text-xs"></i>
                            </div>
                        </div>
                        <h6 class="font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors"><?php echo e($category->name); ?></h6>
                        <span class="inline-flex items-center bg-slate-100 text-slate-500 text-xs font-semibold px-3 py-1 rounded-full">
                            <?php echo e($category->products_count); ?> Produk
                        </span>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <div class="text-slate-200 mb-6">
                    <i class="bi bi-tags text-7xl"></i>
                </div>
                <h3 class="font-bold text-2xl text-slate-800 mb-3">Belum Ada Kategori</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-8">Kategori produk saat ini belum tersedia. Silakan cek kembali nanti.</p>
                <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-6 py-3 rounded-full transition-all active:scale-95 shadow-sm shadow-emerald-500/20">
                    Lihat Semua Produk
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/categories/index.blade.php ENDPATH**/ ?>