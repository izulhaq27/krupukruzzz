@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Products -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 4px;">
                <div class="d-flex justify-content-between">
                    <div style="width: 45px; height: 45px; background: #eff2f7; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3C50E0;">
                        <i class="bi bi-box-seam-fill fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="fw-bold mb-1 text-dark">{{ $totalProducts }}</h3>
                    <small class="text-muted">Total Products</small>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 4px;">
                <div class="d-flex justify-content-between">
                    <div style="width: 45px; height: 45px; background: #eff2f7; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3C50E0;">
                        <i class="bi bi-currency-dollar fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="fw-bold mb-1 text-dark">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <small class="text-muted">Total Paid Revenue</small>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 4px;">
                <div class="d-flex justify-content-between">
                    <div style="width: 45px; height: 45px; background: #eff2f7; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3C50E0;">
                        <i class="bi bi-cart-check-fill fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="fw-bold mb-1 text-dark">{{ $newOrders }}</h3>
                    <small class="text-muted">Pending Orders</small>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 4px;">
                <div class="d-flex justify-content-between">
                    <div style="width: 45px; height: 45px; background: #eff2f7; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #3C50E0;">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <h3 class="fw-bold mb-1 text-dark">{{ $totalUsers }}</h3>
                    <small class="text-muted">Total Users</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-3 mb-4">
        <!-- Revenue Chart -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 4px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Monthly Revenue</h5>
                        <p class="text-muted small mb-0">Year {{ date('Y') }}</p>
                    </div>
                </div>
                <canvas id="revenueChart" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <!-- Weekly Sales Chart -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 4px;">
                <h5 class="fw-bold text-dark mb-4">Orders This Week</h5>
                <canvas id="profitChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card border-0 shadow-sm" style="border-radius: 4px;">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3">Pesanan Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th class="fw-normal">ORDER ID</th>
                            <th class="fw-normal">CUSTOMER</th>
                            <th class="fw-normal">TOTAL</th>
                            <th class="fw-normal">STATUS</th>
                            <th class="fw-normal">DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestOrders as $order)
                        <tr>
                            <td class="py-3">
                                <span class="fw-bold text-dark">#{{ $order->id }}</span>
                            </td>
                            <td>
                                <span class="d-block text-dark">{{ $order->user->name ?? 'Guest' }}</span>
                            </td>
                            <td class="text-dark fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status == 'paid')
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Paid</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Pending</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Real Data from Controller
    const monthlyRevenue = @json($monthlyRevenue);
    const weeklySales = @json($dailySales);

    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Revenue (Rp)',
                data: monthlyRevenue,
                borderColor: '#3C50E0',
                backgroundColor: 'rgba(60, 80, 224, 0.05)',
                tension: 0.3,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            plugins: {
                legend: { position: 'top', align: 'start' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { borderDash: [2, 2] },
                    ticks: {
                        callback: function(value, index, values) {
                            return 'Rp ' + (value/1000).toLocaleString() + 'k';
                        }
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // Orders Weekly Chart
    const ctx2 = document.getElementById('profitChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Orders',
                data: weeklySales,
                backgroundColor: '#3C50E0',
                borderRadius: 4
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { precision: 0 } 
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>

<style>
    .card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
</style>
@endsection