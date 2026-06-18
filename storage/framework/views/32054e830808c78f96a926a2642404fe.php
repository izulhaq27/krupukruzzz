<?php $__env->startSection('title', 'Daftar Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">Admin</li>
                    <li><span class="mx-2 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800" aria-current="page">Pesanan</li>
                </ol>
            </nav>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Pesanan</h2>
                <span class="bg-[#5C5DCD]/10 text-[#5C5DCD] text-xs font-bold px-2.5 py-1 rounded-full"><?php echo e($orders->count()); ?> total</span>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button class="bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-filter"></i>
                Filter
            </button>
            <button class="bg-[#1D2438] hover:bg-[#171C2B] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-download"></i>
                Ekspor Data
            </button>
        </div>
    </div>

    <!-- Stats summary for Orders (Optional matching design) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#5C5DCD]/10 text-[#5C5DCD] flex items-center justify-center text-xl">
                <i class="bi bi-receipt"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Pesanan</p>
                <h3 class="text-xl font-bold text-slate-900"><?php echo e($orders->count()); ?></h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Diproses</p>
                <h3 class="text-xl font-bold text-slate-900"><?php echo e($orders->where('status', 'pending')->count()); ?></h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="bi bi-check2-circle"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Selesai (Hari ini)</p>
                <h3 class="text-xl font-bold text-slate-900"><?php echo e($orders->where('status', 'paid')->count()); ?></h3>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Order ID</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Customer</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- ID -->
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-900">#<?php echo e($order->id); ?></span>
                        </td>
                        
                        <!-- Customer -->
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                    <i class="bi bi-person-fill text-lg"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900"><?php echo e($order->name); ?></div>
                                    <div class="text-xs text-slate-500"><?php echo e($order->email ?? $order->phone ?? '-'); ?></div>
                                </div>
                            </div>
                        </td>

                        <!-- Tanggal -->
                        <td class="py-4 px-6">
                            <div class="text-sm font-medium text-slate-900"><?php echo e($order->created_at->format('d M Y')); ?></div>
                            <div class="text-xs text-slate-500"><?php echo e($order->created_at->format('H:i')); ?></div>
                        </td>

                        <!-- Total -->
                        <td class="py-4 px-6">
                            <div class="font-bold text-[#5C5DCD]">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></div>
                            <div class="text-xs text-slate-500 truncate max-w-[150px]">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($item->product_name); ?><?php echo e(!$loop->last ? ',' : ''); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-6">
                            <?php
                                $statusClasses = match($order->status) {
                                    'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'processed' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'paid' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                    'failed' => 'bg-red-100 text-red-700 border-red-200',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                                };
                                $dotColor = match($order->status) {
                                    'pending' => 'bg-amber-500',
                                    'processed' => 'bg-blue-500',
                                    'paid', 'completed' => 'bg-emerald-500',
                                    'cancelled', 'failed' => 'bg-red-500',
                                    default => 'bg-slate-500'
                                };
                            ?>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border <?php echo e($statusClasses); ?>">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 <?php echo e($dotColor); ?>"></span>
                                <?php echo e($order->status_label ?? ucfirst($order->status)); ?>

                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="/admin/orders/<?php echo e($order->id); ?>" class="p-2 text-slate-400 hover:text-[#5C5DCD] hover:bg-[#5C5DCD]/10 rounded-lg transition-colors" title="Detail">
                                    <i class="bi bi-eye-fill text-lg"></i>
                                </a>

                                <?php if(!$order->tracking_number && !in_array($order->status, ['cancelled', 'failed'])): ?>
                                <a href="/admin/orders/<?php echo e($order->id); ?>#resi-form" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Input Resi">
                                    <i class="bi bi-truck text-lg"></i>
                                </a>
                                <?php endif; ?>

                                <?php if(in_array($order->status, ['cancelled', 'failed'])): ?>
                                <form action="<?php echo e(route('admin.orders.destroy', $order->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus pesanan ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="bi bi-trash-fill text-lg"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="w-16 h-16 mx-auto bg-slate-50 rounded-full flex items-center justify-center text-slate-400 mb-4">
                                <i class="bi bi-cart-x text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Belum ada pesanan</h3>
                            <p class="text-slate-500">Daftar pesanan yang masuk akan muncul di sini.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>