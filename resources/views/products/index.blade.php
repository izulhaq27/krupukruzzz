@extends('layouts.app')

@section('content')
<!-- Hero Section (Static Visual Only) -->
<div class="container-fluid px-lg-5 mb-4"> <!-- FULL WIDTH with Padding -->
    <div class="rounded-4 p-4 p-lg-5 text-white position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%); min-height: 250px; display: flex; align-items: center;"> 
        
        <!-- Background Pattern/Image (Optional) -->
        <div style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; opacity: 0.1; background-image: url('https://www.transparenttextures.com/patterns/food.png');"></div>

        <div class="row align-items-center position-relative z-1 w-100">
            <div class="col-lg-7 col-12 text-start">
                <!-- Responsive Typography: Display-4 for desktop, smaller for mobile -->
                <h1 class="fw-bold display-4 d-none d-lg-block mb-2">Selamat Datang di KrupuKruzzz</h1>
                <h1 class="fw-bold fs-2 d-lg-none mb-2">Selamat Datang di KrupuKruzzz</h1>
                
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

    <div class="row g-2 g-md-3"> <!-- Smaller Gap for Mobile -->
        @foreach ($products as $product)
        <!-- GRID ADJUSTMENT: col-4 for mobile (3 items) as requested, or col-6 (2 items) -->
        <!-- User asked for "3 baris" (3 rows/lines/cols?). Assuming 3 Columns for "card" -->
        <div class="col-xl-2 col-lg-3 col-md-4 col-4"> 
            <div class="card product-card h-100 bg-white" style="border: 1px solid #f0f0f0;">
                
                <!-- Position Relative for Badge -->
                <div class="position-relative">
                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <!-- FOTO -->
                        <div class="skeleton-loader" style="width: 100%; aspect-ratio: 1/1; overflow: hidden; background: #eee;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover; transition: transform 0.3s;"
                                     alt="{{ $product->name }}"
                                     loading="lazy">
                            @else
                                <div class="w-100 h-100 d-flex justify-content-center align-items-center text-muted">
                                    <i class="bi bi-image fs-1 opacity-25"></i>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>

                <!-- CARD BODY -->
                <div class="card-body p-2 p-md-3 d-flex flex-column">
                    <!-- Categories -->
                    <div class="mb-1 mb-md-2">
                        @foreach($product->categories->take(1) as $cat)
                            <span class="badge bg-light text-secondary border fw-normal" style="font-size: 0.65rem;">{{ $cat->name }}</span>
                        @endforeach
                    </div>

                    <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                        <h6 class="card-title fw-semibold text-dark mb-1 text-truncate" style="font-size: 0.9rem;">{{ $product->name }}</h6>
                    </a>
                    
                    <div class="d-flex align-items-baseline mb-2 mb-md-3 flex-wrap">
                        <span class="fw-bold" style="color: var(--primary-green); font-size: 1rem;">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- BUTTONS -->
                    <div class="mt-auto d-flex gap-1">
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm flex-grow-0 px-2" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="redirect_to" value="cart">
                                <button type="submit" class="btn btn-outline-success btn-sm w-100 fw-medium py-1">
                                    <i class="bi bi-cart-plus"></i> <span class="d-none d-md-inline">Beli</span>
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
        0% { background-color: #f0f0f0; }
        100% { background-color: #e0e0e0; }
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

    /* Mobile Interaction - NO STICKY HOVER */
    @media (max-width: 576px) {
        .product-card {
            border-radius: 8px;
        }
        .card-title {
            font-size: 0.8rem !important;
        }
        .product-card:active {
            background-color: #f8f9fa !important;
        }
    }
</style>
@endsection