@extends('layouts.app')

@section('title', 'Checkout Berhasil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5 text-center">
                    <!-- Icon Success -->
                    <div class="mb-4">
                        <div style="
                            width: 80px;
                            height: 80px;
                            background: #28a745;
                            border-radius: 50%;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-size: 2rem;
                        ">
                            ✓
                        </div>
                    </div>
                    
                    <h1 class="fw-bold mb-3" style="color: #28a745;">
                        Checkout Berhasil!
                    </h1>
                    
                    <p class="text-muted mb-4">
                        Terima kasih telah berbelanja di toko kami. Pesanan Anda sedang diproses.
                    </p>
                    
                    <!-- Order Summary -->
                    <div class="card mb-4 border-0 shadow-sm" style="background: #f8f9fa;">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 fw-bold">📋 Detail Pesanan</h5>
                            
                            <div class="row g-3 text-start">
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Nomor Order</small>
                                    <strong class="text-break">{{ $order->order_number }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Tanggal</small>
                                    <strong>{{ $order->created_at->format('d F Y H:i') }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Total</small>
                                    <h5 class="fw-bold mb-0" style="color: #28a745;">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </h5>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }} px-3 py-2">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                                @if($order->payment_type)
                                <div class="col-12 mt-3 pt-3 border-top">
                                    <small class="text-muted d-block">Metode Pembayaran</small>
                                    <strong class="fs-5">{{ $order->payment_type_label }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Logic Simplified: No Snap Token + Pending = Show Manual Upload --}}
                    @if(!$order->snap_token && $order->status == 'pending')
                    <div class="alert alert-info border-0 shadow-sm mb-4 text-start p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-bank"></i> Instruksi Pembayaran Manual</h6>
                            <span class="badge bg-light text-dark border">Transfer Manual</span>
                        </div>
                        
                        <div class="bg-white p-3 rounded mb-3 border shadow-sm">
                            <p class="mb-2 small text-muted">Silakan transfer ke:</p>
                            <h6 class="fw-bold text-dark">Bank Jago</h6>
                            <h4 class="fw-bold text-success mb-1">100641390135</h4>
                            <p class="mb-0 small fw-semibold">a.n. Acmad Machrus Ali</p>
                        </div>

                        <p class="mb-0 small text-muted mt-1">
                            <i class="bi bi-info-circle me-1"></i> Setelah melakukan transfer, silakan unggah bukti pembayaran melalui menu <a href="{{ route('orders.index') }}" class="fw-bold text-decoration-none">Pesanan Saya</a>.
                        </p>
                    </div>
                    @endif

                    <!-- Customer Info -->
                    <div class="card mb-4 border-0 shadow-sm" style="background: #f8f9fa;">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 fw-bold">👤 Informasi Pengiriman</h5>
                            
                            <div class="row g-3 text-start">
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Nama</small>
                                    <strong>{{ $order->name }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Telepon</small>
                                    <strong>{{ $order->phone }}</strong>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block">Alamat</small>
                                    <p class="mb-0">{{ $order->address }}, {{ $order->city }}, {{ $order->province }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-grid d-md-flex gap-3 justify-content-md-center">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-success px-4 py-3">
                            <i class="bi bi-shop me-2"></i>Lanjut Belanja
                        </a>
                        
                        <a href="{{ route('orders.index') }}" class="btn btn-success px-4 py-3 shadow">
                            <i class="bi bi-list-check me-2"></i>Lihat Pesanan Saya
                        </a>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted small mb-2">
                            <i class="bi bi-info-circle"></i>
                            Anda akan menerima email konfirmasi ke <strong>{{ $order->email }}</strong>
                        </p>
                        <p class="text-muted small">
                            Untuk pertanyaan, hubungi kami di <strong>0812-3456-7890</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .table th {
        font-weight: 500;
        color: #6c757d;
    }
    
    .btn {
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 500;
    }
</style>
@endsection