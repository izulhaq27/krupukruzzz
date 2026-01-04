@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-success text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-success text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4 lg-g-5">
        <!-- Product Image Section -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-light h-100 d-flex align-items-center justify-content-center" style="min-height: 400px;">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="img-fluid w-100 h-100" 
                         style="object-fit: contain; max-height: 600px;" 
                         alt="{{ $product->name }}"
                         fetchpriority="high"
                         decoding="async">
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-image display-1 text-muted opacity-25"></i>
                        <p class="text-muted mt-2">Gambar tidak tersedia</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info Section -->
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <!-- Badges & Status -->
                <div class="mb-3">
                    @foreach($product->categories as $category)
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-normal me-2 mb-2">
                             {{ $category->name }}
                        </span>
                    @endforeach
                    @if($product->stock > 0)
                        <span class="badge bg-light text-success border px-2 py-1 rounded small">
                            <i class="bi bi-check-circle-fill me-2"></i>Stok Tersedia
                        </span>
                    @else
                        <span class="badge bg-light text-danger border px-2 py-1 rounded small">
                            <i class="bi bi-x-circle-fill me-2"></i>Stok Habis
                        </span>
                    @endif
                </div>

                <!-- Product Name -->
                <h1 class="display-6 fw-bold text-dark mb-3">{{ $product->name }}</h1>

                <!-- Price Section -->
                <div class="mb-4">
                    @if($product->discount_price)
                        <div class="d-flex align-items-center gap-3 mb-1">
                            <span class="h2 fw-bold text-success mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-muted text-decoration-line-through fs-5">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            @php
                                $percent = round((($product->discount_price - $product->price) / $product->discount_price) * 100);
                            @endphp
                            <span class="badge bg-danger rounded-pill">-{{ $percent }}%</span>
                        </div>
                    @else
                        <span class="h2 fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                    <p class="text-muted small mt-2">
                        <i class="bi bi-box-seam me-2"></i>Stok sisa: <strong>{{ $product->stock }} unit</strong>
                    </p>
                </div>

                <hr class="my-4 opacity-10">

                <!-- Action Buttons -->
                <div class="row g-3 mb-5">
                    <div class="col-sm-8">
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="redirect_to" value="cart">
                                <button type="submit" class="btn btn-success btn-lg w-100 py-3 rounded-pill shadow-sm transition-hover">
                                    <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-lg w-100 py-3 rounded-pill disabled">
                                <i class="bi bi-dash-circle me-2"></i> Stok Habis
                            </button>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-outline-success btn-lg w-100 py-3 rounded-pill" onclick="window.history.back()">
                             <i class="bi bi-arrow-left me-2"></i>Kembali
                        </button>
                    </div>
                </div>

                <!-- Product Description Box -->
                <div class="card border-0 bg-light rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-text-left text-success me-2"></i> Deskripsi Produk
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-muted lh-lg" style="white-space: pre-line;">
                            @if($product->description)
                                {!! nl2br(e($product->description)) !!}
                            @else
                                <span class="fst-italic">Tidak ada deskripsi untuk produk ini.</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Tambahan (Visual Only) -->
                <div class="mt-4 d-flex gap-4">
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 mb-2 mx-auto" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <small class="text-muted d-block">Original</small>
                    </div>
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 mb-2 mx-auto" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <small class="text-muted d-block">Fresh</small>
                    </div>
                    <div class="text-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 mb-2 mx-auto" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-truck"></i>
                        </div>
                        <small class="text-muted d-block">Cepat</small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb-item + .breadcrumb-item::before {
        content: "\F285"; /* bi-chevron-right */
        font-family: bi-icons;
        font-size: 0.8rem;
    }
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(46, 125, 50, 0.2) !important;
    }
</style>
@endsection