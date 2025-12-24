

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color: #1e293b;">Kelola Kategori</h4>
        <p class="text-muted mb-0 small">Total <?php echo e($categories->count()); ?> kategori</p>
    </div>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn fw-bold" 
       style="background: #10b981; color: white; border: none; border-radius: 8px; padding: 8px 16px;">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 10px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th class="border-0" style="padding: 16px; color: #64748b; width: 60px;">NO</th>
                        <th class="border-0" style="padding: 16px; color: #64748b;">Nama Kategori</th>
                        <th class="border-0" style="padding: 16px; color: #64748b; width: 120px;">Produk</th>
                        <th class="border-0" style="padding: 16px; color: #64748b; width: 100px;">Status</th>
                        <th class="border-0 text-center" style="padding: 16px; color: #64748b; width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-bottom">
                        <td style="padding: 16px; color: #475569;">
                            <span class="badge" style="background: #f1f5f9; color: #334155;">
                                <?php echo e($loop->iteration); ?>

                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <?php if($category->image): ?>
                                    <div style="width: 40px; height: 40px; border-radius: 6px; overflow: hidden;">
                                        <img src="<?php echo e(asset('storage/' . $category->image)); ?>" 
                                             alt="<?php echo e($category->name); ?>"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <?php else: ?>
                                    <div style="width: 40px; height: 40px; border-radius: 6px; background: #f1f5f9; 
                                                display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-folder text-muted"></i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium" style="color: #1e293b;"><?php echo e($category->name); ?></div>
                                    <?php if($category->description): ?>
                                    <small class="text-muted" style="font-size: 0.85rem;">
                                        <?php echo e(Str::limit($category->description, 50)); ?>

                                    </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 16px;">
                            <span class="badge" style="background: #e0e7ff; color: #3730a3; padding: 4px 12px; border-radius: 20px;">
                                <?php echo e($category->products_count); ?> produk
                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <span class="badge" style="
                                background: <?php echo e($category->is_active ? '#d1fae5' : '#fee2e2'); ?>;
                                color: <?php echo e($category->is_active ? '#065f46' : '#991b1b'); ?>;
                                padding: 4px 12px;
                                border-radius: 20px;
                                font-weight: 500;
                            ">
                                <?php echo e($category->is_active ? 'Aktif' : 'Nonaktif'); ?>

                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" 
                                   class="btn btn-sm" 
                                   style="
                                        background: #fbbf24;
                                        color: #000;
                                        border: none;
                                        border-radius: 6px;
                                        padding: 6px 12px;
                                        font-size: 0.85rem;
                                   ">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <form method="POST" action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" 
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm" 
                                            style="
                                                background: #ef4444;
                                                color: white;
                                                border: none;
                                                border-radius: 6px;
                                                padding: 6px 12px;
                                                font-size: 0.85rem;
                                            ">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($categories->isEmpty()): ?>
<div class="text-center py-5">
    <div class="mb-3">
        <i class="bi bi-folder display-4" style="color: #cbd5e1;"></i>
    </div>
    <h5 class="text-muted">Belum ada kategori</h5>
    <p class="text-muted small mb-3">Mulai dengan menambahkan kategori pertama</p>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn" 
       style="background: #10b981; color: white; border-radius: 8px;">
        <i class="bi bi-plus-circle me-1"></i> Tambah Kategori Pertama
    </a>
</div>
<?php endif; ?>

<style>
    .table > :not(caption) > * > * {
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }
        
        .table th, 
        .table td {
            padding: 12px 8px !important;
        }
        
        .btn {
            padding: 5px 10px !important;
            font-size: 0.8rem !important;
        }
        
        .d-flex.gap-2 {
            gap: 4px !important;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>