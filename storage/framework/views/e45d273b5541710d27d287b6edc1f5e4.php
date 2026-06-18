<?php $__env->startSection('title', 'Manajemen Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
    <div x-data="{ show: true }" x-show="show" class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i class="bi bi-check-circle-fill text-emerald-500 text-xl"></i>
            <span class="font-medium"><?php echo e(session('success')); ?></span>
        </div>
        <button @click="show = false" class="text-emerald-600 hover:text-emerald-800"><i class="bi bi-x-lg"></i></button>
    </div>
    <?php endif; ?>

    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center"><a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-slate-900">Admin</a></li>
                    <li><span class="mx-2 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800" aria-current="page">Kategori</li>
                </ol>
            </nav>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Kategori</h2>
                <span class="bg-[#5C5DCD]/10 text-[#5C5DCD] text-xs font-bold px-2.5 py-1 rounded-full">Total <?php echo e($categories->count()); ?></span>
            </div>
        </div>
        
        <div>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-[#1D2438] hover:bg-[#171C2B] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900">Daftar Kategori</h3>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">NO</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Produk</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- NO -->
                        <td class="py-4 px-6 text-sm font-medium text-slate-500">
                            <?php echo e($loop->iteration); ?>

                        </td>
                        
                        <!-- Nama & Gambar -->
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200 flex items-center justify-center">
                                    <?php if($category->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <i class="bi bi-folder text-slate-400 text-xl"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900"><?php echo e($category->name); ?></div>
                                    <?php if($category->description): ?>
                                    <div class="text-xs text-slate-500 truncate max-w-[200px]" title="<?php echo e($category->description); ?>">
                                        <?php echo e(Str::limit($category->description, 50)); ?>

                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <!-- Produk Count -->
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                <?php echo e($category->products_count); ?> produk
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-6">
                            <?php if($category->is_active): ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Nonaktif
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="bi bi-trash-fill text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="w-16 h-16 mx-auto bg-slate-50 rounded-full flex items-center justify-center text-slate-400 mb-4">
                                <i class="bi bi-folder-x text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Belum ada kategori</h3>
                            <p class="text-slate-500 mb-4">Mulai dengan menambahkan kategori pertama Anda.</p>
                            <a href="<?php echo e(route('admin.categories.create')); ?>" class="inline-flex items-center gap-2 bg-[#1D2438] hover:bg-[#171C2B] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Kategori
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>