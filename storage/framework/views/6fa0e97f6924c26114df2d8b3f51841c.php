

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0" style="color: #1e293b;">Daftar Users</h4>
            <p class="text-muted mb-0 small">Total <?php echo e($users->count()); ?> pengguna</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 10px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="border-0" style="padding: 16px; color: #64748b; width: 70px;">ID</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; min-width: 180px;">Nama</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; min-width: 200px;">Email</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; min-width: 130px;">Telepon</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; min-width: 250px;">Alamat</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; min-width: 120px;">Kota</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; min-width: 120px;">Provinsi</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; min-width: 100px;">Kode Pos</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; width: 100px;">Role</th>
                            <th class="border-0" style="padding: 16px; color: #64748b; width: 100px;">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-bottom">
                            <td style="padding: 16px;">
                                <span class="badge" style="background: #f1f5f9; color: #334155; font-weight: 500;">
                                    #<?php echo e($user->id); ?>

                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div style="
                                            width: 40px; 
                                            height: 40px; 
                                            border-radius: 50%; 
                                            background: <?php echo e($user->is_admin ? '#10b981' : '#3b82f6'); ?>;
                                            display: flex; 
                                            align-items: center; 
                                            justify-content: center;
                                            color: white;
                                            font-weight: 500;
                                            font-size: 0.9rem;
                                        ">
                                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="fw-medium" style="color: #1e293b;"><?php echo e($user->name); ?></div>
                                        <small class="text-muted" style="font-size: 0.85rem;">
                                            ID: <?php echo e($user->id); ?>

                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px;">
                                <a href="mailto:<?php echo e($user->email); ?>" 
                                   class="text-decoration-none d-flex align-items-center"
                                   style="color: #3b82f6;">
                                    <i class="bi bi-envelope me-2" style="font-size: 0.9rem;"></i>
                                    <span style="word-break: break-all;"><?php echo e($user->email); ?></span>
                                </a>
                            </td>
                            <td style="padding: 16px; color: #475569;">
                                <?php if($user->phone): ?>
                                <a href="tel:<?php echo e($user->phone); ?>" 
                                   class="text-decoration-none d-flex align-items-center"
                                   style="color: #475569;">
                                    <i class="bi bi-telephone me-2" style="font-size: 0.9rem;"></i>
                                    <?php echo e($user->phone); ?>

                                </a>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px;">
                                <div style="
                                    max-height: 60px; 
                                    overflow-y: auto;
                                    color: #475569;
                                    line-height: 1.4;
                                    font-size: 0.9rem;
                                ">
                                    <?php if($user->address): ?>
                                        <?php echo e($user->address); ?>

                                    <?php else: ?>
                                        <span class="text-muted fst-italic">Belum diisi</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td style="padding: 16px; color: #475569;">
                                <?php if($user->city): ?>
                                    <?php echo e($user->city); ?>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px; color: #475569;">
                                <?php if($user->province): ?>
                                    <?php echo e($user->province); ?>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px; color: #475569;">
                                <?php if($user->postal_code): ?>
                                    <span class="badge" style="
                                        background: #f1f5f9; 
                                        color: #475569;
                                        padding: 4px 10px;
                                        border-radius: 6px;
                                        font-weight: 500;
                                    ">
                                        <?php echo e($user->postal_code); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px;">
                                <?php if($user->is_admin): ?>
                                    <span class="badge" style="
                                        background: #10b981; 
                                        color: white;
                                        padding: 4px 12px;
                                        border-radius: 20px;
                                        font-weight: 500;
                                    ">
                                        Admin
                                    </span>
                                <?php else: ?>
                                    <span class="badge" style="
                                        background: #f1f5f9; 
                                        color: #475569;
                                        padding: 4px 12px;
                                        border-radius: 20px;
                                        font-weight: 500;
                                    ">
                                        User
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 16px; color: #64748b;">
                                <div class="text-center">
                                    <div class="fw-medium" style="font-size: 0.9rem;">
                                        <?php echo e($user->created_at->format('d/m')); ?>

                                    </div>
                                    <small class="text-muted">
                                        <?php echo e($user->created_at->format('Y')); ?>

                                    </small>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if($users->isEmpty()): ?>
    <div class="text-center py-5">
        <div class="mb-3">
            <i class="bi bi-people display-4" style="color: #cbd5e1;"></i>
        </div>
        <h5 class="text-muted">Belum ada pengguna</h5>
        <p class="text-muted small">Tidak ada user terdaftar</p>
    </div>
    <?php endif; ?>
</div>

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
        
        /* Sembunyikan beberapa kolom di mobile */
        .table thead th:nth-child(4), /* Telepon */
        .table thead th:nth-child(6), /* Provinsi */
        .table thead th:nth-child(7), /* Kode Pos */
        .table tbody td:nth-child(4),
        .table tbody td:nth-child(6),
        .table tbody td:nth-child(7) {
            display: none;
        }
        
        h4 {
            font-size: 1.25rem;
        }
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/admin/users/index.blade.php ENDPATH**/ ?>