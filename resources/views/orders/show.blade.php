@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- BREADCRUMB -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
                </ol>
            </nav>

            <!-- HEADER -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h1 class="h3 fw-bold text-success mb-2 text-nowrap" style="font-size: calc(1.3rem + .6vw);">
                        <i class="bi bi-receipt me-2"></i>Detail Pesanan
                    </h1>
                    <p class="text-muted mb-0 small">No. Pesanan: <strong class="text-break">{{ $order->order_number }}</strong></p>
                </div>
                <div class="d-flex gap-2 w-100 w-md-auto">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary flex-fill flex-md-grow-0 text-nowrap">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('orders.invoice', $order->order_number) }}" class="btn btn-success flex-fill flex-md-grow-0 text-nowrap">
                        <i class="bi bi-printer me-2"></i>Invoice
                    </a>
                </div>
            </div>

            <!-- NOTIFICATION -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- LEFT COLUMN -->
                <div class="col-lg-8">
                    <!-- STATUS TIMELINE -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-clock-history text-success me-2"></i> Status Pesanan
                            </h5>
                            
                            @php
                                $timeline = [
                                    'pending' => ['label' => 'Menunggu Pembayaran', 'icon' => 'clock'],
                                    'paid' => ['label' => 'Pembayaran Diterima', 'icon' => 'check-circle'],
                                    'processed' => ['label' => 'Pesanan Diproses', 'icon' => 'gear'],
                                    'shipped' => ['label' => 'Pesanan Dikirim', 'icon' => 'truck'],
                                    'completed' => ['label' => 'Pesanan Selesai', 'icon' => 'check2-circle'],
                                ];
                                
                                $currentStatus = $order->status;
                                $statusIndex = array_keys($timeline);
                            @endphp
                            
                            <div class="timeline">
                                @foreach($timeline as $status => $info)
                                    @php
                                        $isActive = in_array($status, array_slice($statusIndex, 0, array_search($currentStatus, $statusIndex) + 1));
                                        $isCurrent = $status == $currentStatus;
                                    @endphp
                                    <div class="timeline-item {{ $isActive ? 'active' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                        <div class="timeline-icon">
                                            <i class="bi bi-{{ $info['icon'] }}"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="fw-bold">{{ $info['label'] }}</h6>
                                            @if($isActive)
                                                @switch($status)
                                                    @case('pending')
                                                        <p class="text-muted small mb-0">Menunggu pembayaran dari Anda</p>
                                                        @break
                                                    @case('paid')
                                                        <p class="text-muted small mb-0">Pembayaran telah dikonfirmasi</p>
                                                        @break
                                                    @case('processed')
                                                        <p class="text-muted small mb-0">Pesanan sedang dipersiapkan</p>
                                                        @break
                                                    @case('shipped')
                                                        <p class="text-muted small mb-0">
                                                            @if($order->shipped_at)
                                                                Dikirim pada {{ $order->shipped_at->format('d F Y, H:i') }}
                                                            @endif
                                                        </p>
                                                        @break
                                                    @case('completed')
                                                        <p class="text-muted small mb-0">
                                                            @if($order->delivered_at)
                                                                Selesai pada {{ $order->delivered_at->format('d F Y, H:i') }}
                                                            @endif
                                                        </p>
                                                        @break
                                                @endswitch
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- ITEMS -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-cart text-success me-2"></i> Item Pesanan
                            </h5>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                             alt="{{ $item->product_name }}" 
                                                             class="rounded me-3" 
                                                             style="width: 60px; height: 60px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <h6 class="fw-bold mb-1">{{ $item->product_name }}</h6>
                                                        <small class="text-muted">SKU: {{ $item->product_sku ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">{{ $item->quantity }}</td>
                                            <td class="text-end align-middle">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-end align-middle fw-bold">
                                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-lg-4">
                    <!-- INFO PESANAN -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-info-circle text-success me-2"></i> Info Pesanan
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-6 col-lg-12">
                                    <small class="text-muted d-block">Tanggal Pesanan</small>
                                    <strong>{{ $order->created_at->format('d F Y') }}</strong>
                                    <small class="text-muted d-block small">{{ $order->created_at->format('H:i') }}</small>
                                </div>
                                
                                <div class="col-6 col-lg-12">
                                    <small class="text-muted d-block">Status</small>
                                    @php
                                        $statusConfig = [
                                            'pending' => ['color' => 'warning', 'label' => 'Menunggu Pembayaran'],
                                            'paid' => ['color' => 'info', 'label' => 'Dibayar'],
                                            'processed' => ['color' => 'primary', 'label' => 'Diproses'],
                                            'shipped' => ['color' => 'success', 'label' => 'Dikirim'],
                                            'completed' => ['color' => 'dark', 'label' => 'Selesai'],
                                        ];
                                        $config = $statusConfig[$order->status] ?? ['color' => 'secondary', 'label' => $order->status];
                                    @endphp
                                    <span class="badge bg-{{ $config['color'] }} px-3 py-2">
                                        {{ $config['label'] }}
                                    </span>
                                </div>
                            </div>
                            @if($order->notes)
                            <div class="mb-3">
                                <small class="text-muted d-block">Catatan</small>
                                <p class="mb-0">{{ $order->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- INFO PENGIRIMAN -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-truck text-success me-2"></i> Info Pengiriman
                            </h5>
                            
                            @if($order->shipping_courier)
                            <div class="row g-3">
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
                                        <code class="me-2 fs-6">{{ $order->tracking_number }}</code>
                                        @if($order->tracking_link)
                                        <a href="{{ $order->tracking_link }}" target="_blank" 
                                           class="btn btn-sm btn-success">
                                            <i class="bi bi-box-arrow-up-right me-2"></i>Lacak
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                
                                @if($order->shipping_cost)
                                <div class="col-12">
                                    <small class="text-muted d-block">Ongkir</small>
                                    <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                                </div>
                                @endif
                            </div>
                            @else
                            <p class="text-muted mb-0">Belum ada info pengiriman</p>
                            @endif
                        </div>
                    </div>

                    <!-- RINGKASAN PEMBAYARAN -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-4">
                                <i class="bi bi-currency-dollar text-success me-2"></i> Ringkasan Pembayaran
                            </h5>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <strong>Rp {{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 0, ',', '.') }}</strong>
                            </div>
                            
                            @if($order->shipping_cost)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkos Kirim</span>
                                <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
                            </div>
                            @endif
                            
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total</span>
                                <h4 class="fw-bold text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h4>
                            </div>
                            
                            @if($order->payment_type)
                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted d-block">Metode Pembayaran</small>
                                <strong>{{ $order->payment_type_label }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- ========== AKSI TOMBOL YANG BERFUNGSI ========== -->
                    @if($order->status == 'pending')
                    <div class="mt-4">
                        @if($order->payment_type == 'manual_transfer')
                            <div class="card border-warning mb-4 shadow-sm">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="bi bi-upload me-2"></i>Unggah Bukti Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    @if($order->payment_proof)
                                        <div class="alert alert-success mb-3">
                                            <i class="bi bi-info-circle me-2"></i>Bukti pembayaran telah diunggah. Menunggu konfirmasi admin.
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">Bukti Anda:</small>
                                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid rounded border" style="max-height: 200px;" alt="Bukti Pembayaran">
                                        </div>
                                    @endif

                                    <form action="{{ route('orders.upload-payment-proof', $order->order_number) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3 text-start">
                                            <label class="form-label">Nama Bank Pengirim</label>
                                            <input type="text" name="bank_name" class="form-control" placeholder="BRI, BCA, Mandiri" value="{{ old('bank_name', $order->bank_name) }}" required>
                                        </div>
                                        <div class="mb-3 text-start">
                                            <label class="form-label">Foto Bukti Transfer</label>
                                            <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                            <small class="text-muted">Format: JPG, PNG, Max 2MB</small>
                                        </div>
                                        <button type="submit" class="btn btn-warning w-100 fw-bold">
                                            {{ $order->payment_proof ? 'Ganti Bukti Transfer' : 'Unggah Bukti Sekarang' }}
                                        </button>
                                    </form> 
                                    <div class="mt-4 bg-light p-3 rounded text-start border-start border-warning border-4">
                                        <h6 class="fw-bold small mb-2 text-uppercase text-warning"><i class="bi bi-bank me-2"></i>Rekening Tujuan:</h6>
                                        <p class="mb-1 small"><strong>Bank Jago</strong></p>
                                        <p class="mb-1 small">No. Rek: <strong class="text-dark">100641390135</strong></p>
                                        <p class="mb-0 small">Atas nama : Achmad Machrus Ali</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- TOMBOL BAYAR SEKARANG (Midtrans) -->
                        <form action="{{ route('orders.pay', $order->order_number) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 py-3" 
                                    onclick="return confirm('Lanjutkan pembayaran otomatis via Midtrans/Manual Transfer?')">
                                <i class="bi bi-credit-card me-2"></i> {{ $order->payment_type == 'manual_transfer' ? 'Ganti ke Pembayaran Otomatis' : 'Bayar Sekarang (Otomatis)' }}
                            </button>
                        </form>
                        
                        <!-- TOMBOL BATALKAN PESANAN -->
                        <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 py-2" 
                                    onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                <i class="bi bi-x-circle me-2"></i> Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                    @endif
                    
                    @if($order->status == 'shipped')
                    <div class="mt-4">
                        <form action="{{ route('orders.confirm-received', $order->order_number) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 py-3" 
                                    onclick="return confirm('Konfirmasi pesanan sudah diterima?')">
                                <i class="bi bi-check-circle me-2"></i> Konfirmasi Diterima
                            </button>
                        </form>
                    </div>
                    @endif
                    
                    @if($order->status == 'completed')
                    <div class="mt-4">
                        <div class="alert alert-success">
                            <i class="bi bi-check2-circle me-2"></i>
                            Pesanan ini sudah selesai. Terima kasih telah berbelanja di KrupuKruzzz!
                        </div>
                        <form action="{{ route('orders.reorder', $order->order_number) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="bi bi-arrow-repeat me-2"></i> Pesan Lagi
                            </button>
                        </form>
                    </div>
                    @endif
                    
                    @if($order->status == 'cancelled')
                    <div class="mt-4">
                        <div class="alert alert-warning">
                            <i class="bi bi-x-octagon me-2"></i>
                            Pesanan ini telah dibatalkan.
                        </div>
                        <a href="{{ route('products.index') }}" class="btn btn-success w-100">
                            <i class="bi bi-cart-plus me-2"></i> Belanja Lagi
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }
    
    .timeline-item.active::before {
        background-color: #28a745;
    }
    
    .timeline-item.current .timeline-icon {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
    
    .timeline-item.active .timeline-content h6 {
        color: #28a745;
    }
    
    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: white;
        border: 2px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    
    .timeline-content {
        padding-bottom: 8px;
        margin-left: 20px; /* Fix overlap with icon */
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .breadcrumb-item a {
        color: #28a745;
        text-decoration: none;
    }
    
    /* Efek hover untuk tombol */
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
    }
</style>
@endsection