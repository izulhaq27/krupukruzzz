<?php $__env->startSection('title', 'Ringkasan Dashboard'); ?>

<?php
    $hour = date('H');
    if ($hour < 11) {
        $greeting = 'Selamat Pagi';
    } elseif ($hour < 15) {
        $greeting = 'Selamat Siang';
    } elseif ($hour < 18) {
        $greeting = 'Selamat Sore';
    } else {
        $greeting = 'Selamat Malam';
    }
?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Page Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">Admin</li>
                    <li><span class="mx-2 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800" aria-current="page">Ringkasan Dashboard</li>
                </ol>
            </nav>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight"><?php echo e($greeting); ?>, Admin</h2>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Date Range Picker (Dummy) -->
            <button class="bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-calendar3 text-slate-400"></i>
                01 Jan - 31 Jan
            </button>
            <!-- Export Button -->
            <button class="bg-[#5C5DCD] hover:bg-[#4B4CB5] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-download"></i>
                Export
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Products -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg sm:text-xl group-hover:scale-110 transition-transform duration-300">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
            </div>
            <div>
                <p class="text-xs sm:text-sm font-medium text-slate-500 mb-1 uppercase tracking-wider">Total Produk</p>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900"><?php echo e($totalProducts); ?></h3>
            </div>
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg sm:text-xl group-hover:scale-110 transition-transform duration-300">
                    <i class="bi bi-wallet2"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-[10px] sm:text-xs font-medium">
                    <i class="bi bi-graph-up-arrow"></i> +12.5%
                </span>
            </div>
            <div>
                <p class="text-xs sm:text-sm font-medium text-slate-500 mb-1 uppercase tracking-wider">Total Penjualan</p>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h3>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-2">Dibandingkan bulan lalu</p>
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg sm:text-xl group-hover:scale-110 transition-transform duration-300">
                    <i class="bi bi-cart-check-fill"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-[10px] sm:text-xs font-medium">
                    <i class="bi bi-graph-up-arrow"></i> +8.2%
                </span>
            </div>
            <div>
                <p class="text-xs sm:text-sm font-medium text-slate-500 mb-1 uppercase tracking-wider">Total Pesanan</p>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900"><?php echo e($newOrders); ?></h3>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-2">Pesanan diproses</p>
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 flex flex-col relative overflow-hidden group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg sm:text-xl group-hover:scale-110 transition-transform duration-300">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div>
                <p class="text-xs sm:text-sm font-medium text-slate-500 mb-1 uppercase tracking-wider">Pelanggan Baru</p>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900"><?php echo e($totalUsers); ?></h3>
            </div>
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-purple-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
        </div>

    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Line Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Statistik Pendapatan</h3>
                    <p class="text-sm text-slate-500">Tahun <?php echo e(date('Y')); ?></p>
                </div>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Weekly Orders Bar Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-900">Pesanan Minggu Ini</h3>
                <p class="text-sm text-slate-500">7 hari terakhir</p>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="profitChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Latest Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">Pesanan Terbaru</h3>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm font-medium text-[#5C5DCD] hover:text-[#4B4CB5] transition-colors">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Order ID</th>
                        <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Customer</th>
                        <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__currentLoopData = $latestOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 text-sm font-bold text-slate-900 whitespace-nowrap">
                            #<?php echo e($order->id); ?>

                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#5C5DCD]/10 text-[#5C5DCD] flex items-center justify-center font-bold text-xs uppercase">
                                    <?php echo e(substr($order->user->name ?? 'G', 0, 1)); ?>

                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900"><?php echo e($order->user->name ?? 'Guest'); ?></div>
                                    <div class="text-xs text-slate-500"><?php echo e($order->user->email ?? '-'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-500 whitespace-nowrap">
                            <?php echo e($order->created_at->format('d M Y, H:i')); ?>

                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <?php if($order->status == 'paid'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Selesai
                                </span>
                            <?php elseif($order->status == 'pending'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Pending
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500 mr-1.5"></span> <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 text-sm font-bold text-slate-900 text-right whitespace-nowrap">
                            Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Chart Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const monthlyRevenue = <?php echo json_encode($monthlyRevenue, 15, 512) ?>;
    const weeklySales = <?php echo json_encode($dailySales, 15, 512) ?>;

    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: monthlyRevenue,
                borderColor: '#5C5DCD',
                backgroundColor: 'rgba(92, 93, 205, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#5C5DCD',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1E293B',
                    padding: 12,
                    titleFont: { family: 'Plus Jakarta Sans', size: 13 },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 14, weight: 'bold' },
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: '#F1F5F9', drawBorder: false },
                    border: { display: false },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 12, color: '#64748B' },
                        callback: function(value) { return 'Rp ' + (value/1000).toLocaleString() + 'k'; }
                    }
                },
                x: { 
                    grid: { display: false },
                    border: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 12, color: '#64748B' } }
                }
            }
        }
    });

    // Orders Weekly Chart
    const ctx2 = document.getElementById('profitChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Pesanan',
                data: weeklySales,
                backgroundColor: '#5C5DCD',
                borderRadius: 6,
                barThickness: 24,
                hoverBackgroundColor: '#4B4CB5'
            }]
        },
        options: {
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1E293B',
                    padding: 12,
                    titleFont: { family: 'Plus Jakarta Sans', size: 13 },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 14, weight: 'bold' }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: '#F1F5F9', drawBorder: false },
                    border: { display: false },
                    ticks: {
                        precision: 0,
                        font: { family: 'Plus Jakarta Sans', size: 12, color: '#64748B' }
                    } 
                },
                x: { 
                    grid: { display: false },
                    border: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 12, color: '#64748B' } }
                }
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>