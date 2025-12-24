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
        <div class="row">
            @foreach($category->products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card product-card h-100 border-0 shadow-sm">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="card-img-top" 
                             alt="{{ $product->name }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                             style="height: 200px;">
                            <i class="bi bi-egg-fried text-muted display-4"></i>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                        
                        @if($product->description)
                            <p class="card-text text-muted small mb-2">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                        @endif
                        
                        <div class="mb-3">
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-box"></i> Stok: {{ $product->stock }}
                            </span>
                        </div>
                        
                        <h4 class="text-success fw-bold mb-3">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </h4>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn btn-outline-success">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            
                            @auth
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="btn btn-success">
                                <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                            </a>
                            @endauth
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
    .product-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.15) !important;
        border-color: #28a745;
    }
    
    .breadcrumb-item a {
        color: #28a745;
        text-decoration: none;
    }
    
    .btn-outline-success.active {
        background-color: #28a745;
        color: white;
    }
</style>
@endsection