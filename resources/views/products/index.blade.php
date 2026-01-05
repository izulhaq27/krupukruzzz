@extends('layouts.app')

@section('content')
<!-- Hero Section (Static Visual Only) -->
<div class="container-fluid px-lg-5 mb-4"> <!-- FULL WIDTH with Padding -->
    <div class="rounded-4 p-4 p-lg-5 text-white position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); min-height: 280px; display: flex; align-items: center;"> 
        
        <!-- Background Pattern/Image (Optional) -->
        <div style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; opacity: 0.1; background-image: url('https://www.transparenttextures.com/patterns/food.png');"></div>

        <div class="row align-items-center position-relative z-1 w-100">
            <div class="col-lg-7 col-12 text-start">
                <!-- Responsive Typography: Display-4 for desktop, smaller for mobile -->
                <h1 class="fw-bold display-3 d-none d-lg-block mb-3">Selamat Datang di KrupuKruzzz</h1>
                <h1 class="fw-bold fs-1 d-lg-none mb-3">Selamat Datang di KrupuKruzzz</h1>
                
                <p class="lead mb-4 opacity-90 fs-6 fs-lg-5">Solusi camilan kerupuk berkualitas, gurih, dan harga bersahabat.</p>
                
                <a href="#produk-list" class="btn btn-white-premium text-success fw-bold px-4 py-2 px-md-5 py-md-3 rounded-pill shadow-sm transition-hover">
                    Belanja Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            
            <!-- Abstract Elements / Bintik-bintik on Desktop Only -->
            <div class="col-lg-5 d-none d-lg-block text-end position-relative">
                 <!-- Element 1: Big Dotted Circle -->
                 <div class="position-absolute" 
                      style="top: -60px; right: 20px; width: 180px; height: 180px; border: 4px dotted rgba(255,255,255,0.3); border-radius: 50%;"></div>
                 
                 <!-- Element 2: Small Dashed Circle -->
                 <div class="position-absolute" 
                      style="bottom: -40px; right: 100px; width: 120px; height: 120px; border: 3px dashed rgba(255,255,255,0.2); border-radius: 50%;"></div>
                 
                 <!-- Element 3: Abstract Shape (Kerupuk-like) -->
                 <div class="position-absolute" 
                      style="top: 20px; right: 80px; width: 60px; height: 60px; background: rgba(255,255,255,0.15); border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: rotate(45deg);"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important; }
    @media (hover: hover) {
        .transition-hover:hover { transform: translateY(-3px) !important; }
    }
    .transition-hover:active { transform: scale(0.92) !important; }
</style>

<div class="container-fluid px-lg-5 my-4" id="produk-list"> <!-- FULL WIDTH -->

    <!-- Section Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-dark m-0">
            <span style="border-left: 4px solid var(--primary-green); padding-left: 10px;">Rekomendasi Produk</span>
        </h4>
    </div>

    <div class="row g-2 g-md-3 justify-content-center"> <!-- Smaller Gap for Mobile, Centered Items -->
        @foreach ($products as $product)
        <!-- GRID ADJUSTMENT: col-xl-2 (6 items/row desktop), col-lg-3 (4 items), col-md-4 (3 items), col-6 (2 items) -->
        <!-- Animation Wrapper -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-6 product-item" style="animation-delay: {{ $loop->iteration * 0.1 }}s;"> 
            <div class="card product-card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative group-hover-trigger">
                
                <!-- Image Wrapper -->
                <div class="position-relative overflow-hidden">
                    <a href="{{ route('products.show', $product->slug) }}" class="d-block">
                        <div class="skeleton-loader ratio ratio-1x1 bg-light">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="w-100 h-100 object-fit-cover transition-transform duration-500"
                                     alt="{{ $product->name }}"
                                     loading="lazy"
                                     decoding="async">
                            @else
                                <div class="w-100 h-100 d-flex justify-content-center align-items-center text-muted">
                                    <i class="bi bi-image fs-1 opacity-25"></i>
                                </div>
                            @endif
                        </div>
                    </a>
                    
                    <!-- Floating Badge (Top Left) -->
                    @if($product->categories->isNotEmpty())
                        <div class="position-absolute top-0 start-0 p-2 z-2">
                            <span class="badge bg-white text-success shadow-sm rounded-pill px-2 py-1 fw-medium" style="font-size: 0.65rem;">
                                {{ $product->categories->first()->name }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- CARD BODY -->
                <div class="card-body p-3 d-flex flex-column">
                    
                    <!-- Product Name -->
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none mb-1">
                        <h6 class="card-title fw-bold text-dark mb-0 text-truncate" style="font-size: 0.95rem; letter-spacing: -0.02em;">
                            {{ $product->name }}
                        </h6>
                    </a>

                    <!-- Price Section -->
                    <div class="mb-3">
                        <span class="fw-bolder text-success" style="font-size: 1.1rem;">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto d-flex gap-2 align-items-center">
                         <!-- View Detail (Icon Only - Secondary) -->
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="btn btn-outline-secondary rounded-pill d-flex align-items-center justify-content-center border-0 bg-light" 
                           style="width: 40px; height: 40px; flex-shrink: 0;"
                           title="Detail Produk">
                            <i class="bi bi-arrow-right fs-5"></i>
                        </a>

                        <!-- Buy Button (Primary - Pill Shaped) -->
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="redirect_to" value="cart">
                                <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold d-flex align-items-center justify-content-center shadow-sm py-2" style="font-size: 0.85rem;">
                                    <i class="bi bi-bag-plus-fill me-1 fs-6"></i> 
                                    <span class="d-none d-sm-inline">Beli Sekarang</span>
                                    <span class="d-inline d-sm-none">Beli</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($products->isEmpty())
        <div class="text-center py-5">
            <div class="opacity-25 mb-3">
                <i class="bi bi-search display-1 text-secondary"></i>
            </div>
            <h5 class="text-muted">Produk belum tersedia</h5>
        </div>
    @endif

</div>

<style>
    /* Skeleton Animation */
    @keyframes skeleton-loading {
        0% { background-color: rgba(240, 240, 240, 0.5); }
        100% { background-color: rgba(224, 224, 224, 0.5); }
    }
    
    /* Entrance Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-item {
        opacity: 0; /* Hidden initially */
        animation: fadeInUp 0.6s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }
    .skeleton-loader {
        animation: skeleton-loading 1s linear infinite alternate;
    }

    /* Hero Hover Effect - Desktop Only */
    @media (hover: hover) {
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        }
        
        .product-card:hover img {
            transform: scale(1.05);
        }
        .btn-light:hover {
            background-color: #f8f9fa !important;
            color: #2e7d32 !important;
        }
    }

    /* Base Card Style for smooth transitions */
    .product-card {
        transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid rgba(0,0,0,0.04) !important; /* Extremely subtle border */
    }

    .object-fit-cover {
        object-fit: cover;
    }
    
    .shadow-sm-hover:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2) !important;
    }

    /* Mobile Interaction - NO STICKY HOVER */
    @media (max-width: 576px) {
        .product-card {
            border-radius: 12px !important;
        }
        .card-title {
            font-size: 0.9rem !important; 
        }
        /* Tap effect */
        .product-card:active {
            transform: scale(0.98);
        }
    }

    /* Desktop Hover Effects */
    @media (hover: hover) {
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
            border-color: transparent !important;
        }
        
        .product-card:hover img {
            transform: scale(1.08); /* Slight zoom */
        }
    }
</style>
@endsection