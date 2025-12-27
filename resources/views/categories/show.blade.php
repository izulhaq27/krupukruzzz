@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Header Kategori -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" 
                         alt="{{ $category->name }}"
                         class="rounded-circle me-3"
                         style="width: 80px; height: 80px; object-fit: cover;">
                @else
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-tag text-white fs-3"></i>
                    </div>
                @endif
                
                <div>
                    <h1 class="fw-bold text-success mb-1">{{ $category->name }}</h1>
                    @if($category->description)
                        <p class="text-muted mb-0">{{ $category->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4 text-md-end">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Semua Kategori
            </a>
        </div>
    </div>



    <!-- Produk dalam Kategori -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">
                    <i class="bi bi-box"></i> Produk dalam Kategori
                    <span class="badge bg-success ms-2">{{ $category->products->count() }}</span>
                </h4>
                
                <!-- Filter -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-success btn-sm active">Terbaru</button>
                </div>
            </div>
        </div>
    </div>

    <!-- List Produk -->
    @if($category->products->count() > 0)
        <div class="row g-2 g-md-3">
            @foreach($category->products as $product)
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
    @else
        <div class="text-center py-5">
            <i class="bi bi-box display-1 text-muted mb-4"></i>
            <h4 class="fw-bold mb-3">Belum Ada Produk</h4>
            <p class="text-muted mb-4">Tidak ada produk dalam kategori ini saat ini</p>
            <a href="{{ route('products.index') }}" class="btn btn-success">
                Lihat Semua Produk
            </a>
        </div>
    @endif

    <!-- Kategori Lainnya -->
    @if($relatedCategories->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold text-success mb-4">
                <i class="bi bi-grid"></i> Kategori Lainnya
            </h4>
            
            <div class="row">
                @foreach($relatedCategories as $related)
                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('categories.show', $related->slug) }}" 
                       class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 text-center">
                            <div class="card-body">
                                <div class="bg-light rounded-circle mx-auto mb-3" 
                                     style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-tag text-success fs-3"></i>
                                </div>
                                <h6 class="fw-bold text-dark">{{ $related->name }}</h6>
                                <small class="text-muted">
                                    {{ $related->products_count }} Produk
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
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

    .breadcrumb-item a {
        color: var(--primary-green);
        text-decoration: none;
    }
</style>
@endsection