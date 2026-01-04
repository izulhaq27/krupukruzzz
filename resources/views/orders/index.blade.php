@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h1 class="h3 fw-bold text-success mb-2">
                        <i class="bi bi-box-seam me-2"></i>Pesanan Saya
                    </h1>
                    <p class="text-muted mb-0 small">Kelola dan lacak semua pesanan Anda</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger text-nowrap">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                        <a href="{{ route('products.index') }}" class="btn btn-success text-nowrap">
                            <i class="bi bi-plus-circle me-2"></i>Belanja Lagi
                        </a>
                    </div>
                </div>
            </div>

            <!-- FILTER STATUS -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('orders.index') }}" 
                           class="btn btn-outline-secondary btn-sm {{ !request('status') ? 'active' : '' }}">
                            Semua ({{ auth()->user()->orders()->count() }})
                        </a>
                        <a href="{{ route('orders.index', ['status' => 'pending']) }}" 
                           class="btn btn-outline-warning btn-sm {{ request('status') == 'pending' ? 'active' : '' }}">
                            Menunggu Bayar ({{ auth()->user()->pendingOrders()->count() }})
                        </a>
                        <a href="{{ route('orders.index', ['status' => 'processed']) }}" 
                           class="btn btn-outline-primary btn-sm {{ request('status') == 'processed' ? 'active' : '' }}">
                            Diproses ({{ auth()->user()->orders()->where('status', 'processed')->count() }})
                        </a>
                        <a href="{{ route('orders.index', ['status' => 'shipped']) }}" 
                           class="btn btn-outline-info btn-sm {{ request('status') == 'shipped' ? 'active' : '' }}">
                            Dikirim ({{ auth()->user()->orders()->where('status', 'shipped')->count() }})
                        </a>
                        <a href="{{ route('orders.index', ['status' => 'completed']) }}" 
                           class="btn btn-outline-success btn-sm {{ request('status') == 'completed' ? 'active' : '' }}">
                            Selesai ({{ auth()->user()->completedOrders()->count() }})
                        </a>
                    </div>
                </div>
            </div>

            <!-- LIST PESANAN -->
            @if($orders->count() > 0)
                <div class="row">
                    @foreach($orders as $order)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow">
                            <div class="card-body">
                                <!-- HEADER PESANAN -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-uppercase small text-muted">
                                            <i class="bi bi-receipt me-2"></i>NO. PESANAN
                                        </h6>
                                        <h5 class="fw-bold mb-0">{{ $order->order_number }}</h5>
                                    </div>
                                    <div class="text-end">
                                        <h6 class="fw-bold mb-1 text-uppercase small text-muted">
                                            TANGGAL
                                        </h6>
                                        <p class="mb-0">{{ $order->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>

                                <!-- STATUS -->
                                <div class="mb-3">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['color' => 'warning', 'icon' => 'clock', 'label' => 'Menunggu Pembayaran'],
                                            'paid' => ['color' => 'info', 'icon' => 'check-circle', 'label' => 'Dibayar'],
                                            'processed' => ['color' => 'primary', 'icon' => 'gear', 'label' => 'Diproses'],
                                            'shipped' => ['color' => 'success', 'icon' => 'truck', 'label' => 'Dikirim'],
                                            'completed' => ['color' => 'dark', 'icon' => 'check2-circle', 'label' => 'Selesai'],
                                            'cancelled' => ['color' => 'danger', 'icon' => 'x-circle', 'label' => 'Dibatalkan'],
                                            'failed' => ['color' => 'danger', 'icon' => 'exclamation-triangle', 'label' => 'Gagal'],
                                        ];
                                        $config = $statusConfig[$order->status] ?? ['color' => 'secondary', 'icon' => 'question', 'label' => $order->status];
                                    @endphp
                                    
                                    <span class="badge bg-{{ $config['color'] }} px-3 py-2 mb-2">
                                        <i class="bi bi-{{ $config['icon'] }} me-2"></i>{{ $config['label'] }}
                                    </span>
                                </div>

                                <!-- INFO PENGIRIMAN -->
                                @if($order->shipping_courier)
                                <div class="border-top pt-3 mb-3">
                                    <h6 class="fw-bold text-muted small mb-2">
                                        <i class="bi bi-truck"></i> INFO PENGIRIMAN
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Kurir</small>
                                            <strong class="text-uppercase">{{ strtoupper($order->shipping_courier) }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Layanan</small>
                                            <strong>{{ $order->shipping_service ?? 'REG' }}</strong>
                                        </div>
                                        @if($order->tracking_number)
                                        <div class="col-12">
                                            <small class="text-muted d-block">No. Resi</small>
                                            <div class="d-flex align-items-center">
                                                <code class="me-2">{{ $order->tracking_number }}</code>
                                                @if($order->tracking_link)
                                                <a href="{{ $order->tracking_link }}" target="_blank" 
                                                   class="btn btn-sm btn-outline-info py-0">
                                                    <i class="bi bi-box-arrow-up-right"></i> Lacak
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <!-- ITEMS -->
                                <div class="border-top pt-3 mb-3">
                                    <h6 class="fw-bold text-muted small mb-2">
                                        <i class="bi bi-cart"></i> ITEM PESANAN
                                    </h6>
                                    @if($order->items && $order->items->count() > 0)
                                        <ul class="list-unstyled mb-0">
                                            @foreach($order->items->take(2) as $item)
                                                <li class="d-flex justify-content-between mb-1">
                                                    <span>{{ $item->product_name ?? 'Produk' }} × {{ $item->quantity }}</span>
                                                    <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                </li>
                                            @endforeach
                                            @if($order->items->count() > 2)
                                                <li class="text-muted small">
                                                    + {{ $order->items->count() - 2 }} item lainnya
                                                </li>
                                            @endif
                                        </ul>
                                    @else
                                        <p class="text-muted small mb-0">Tidak ada detail item</p>
                                    @endif
                                </div>

                                <!-- TOTAL & AKSI -->
                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block">TOTAL</small>
                                            <h4 class="fw-bold text-success mb-0">
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-3 mt-sm-0 flex-wrap">
                                        <a href="{{ route('orders.show', $order->order_number) }}" 
                                           class="btn btn-outline-primary btn-sm px-3">
                                            <i class="bi bi-eye me-2"></i>Detail
                                        </a>
                                        @if($order->status == 'shipped')
                                            <a href="{{ $order->tracking_link ?? '#' }}" target="_blank"
                                               class="btn btn-success btn-sm px-3">
                                                <i class="bi bi-truck me-2"></i>Lacak
                                            </a>
                                        @endif
                                        @if(in_array($order->status, ['cancelled', 'failed']))
                                            <form action="{{ route('orders.destroy', $order->order_number) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat pesanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                                                    <i class="bi bi-trash me-2"></i>Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- KOSONG -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-cart-x display-1 text-muted"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Belum Ada Pesanan</h4>
                    <p class="text-muted mb-4">Mulai berbelanja dan buat pesanan pertama Anda</p>
                    <a href="{{ route('products.index') }}" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-shop"></i> Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .hover-shadow:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.15) !important;
        border-color: var(--primary-green);
    }
    
    .btn-outline-secondary.active,
    .btn-outline-warning.active,
    .btn-outline-primary.active,
    .btn-outline-info.active,
    .btn-outline-success.active {
        background-color: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
    }
    
    .card {
        border-radius: 12px;
    }
</style>
@endsection