@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
                </ol>
            </nav>
            
            <h1 class="fw-bold text-success mb-3">
                <i class="bi bi-tags"></i> Kategori Produk KrupuKruzzz
            </h1>
            <p class="text-muted">Temukan kerupuk favorit Anda berdasarkan kategori</p>
        </div>
    </div>

    <!-- Kategori Utama -->
    <div class="row">
        @if($categories->count() > 0)
            @foreach($categories as $category)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card category-card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="category-icon mb-3">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}"
                                     class="rounded-circle"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="category-icon-placeholder bg-success rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 80px; height: 80px;">
                                    <i class="bi bi-tag text-white fs-3"></i>
                                </div>
                            @endif
                        </div>
                        
                        <h5 class="fw-bold mb-2">{{ $category->name }}</h5>
                        
                        @if($category->description)
                            <p class="text-muted small mb-3">{{ Str::limit($category->description, 80) }}</p>
                        @endif
                        
                        <div class="mb-3">
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-box"></i> {{ $category->products_count }} Produk
                            </span>
                        </div>
                        
                        <a href="{{ route('categories.show', $category->slug) }}" 
                           class="btn btn-outline-success w-100">
                            Lihat Produk <i class="bi bi-arrow-right"></i>
                        </a>
                        

                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-tag display-1 text-muted mb-4"></i>
                    <h4 class="fw-bold mb-3">Belum Ada Kategori</h4>
                    <p class="text-muted mb-4">Kategori produk akan segera tersedia</p>
                    <a href="{{ route('products.index') }}" class="btn btn-success">
                        <i class="bi bi-arrow-left"></i> Lihat Semua Produk
                    </a>
                </div>
            </div>
        @endif
    </div>


</div>

<style>
    .category-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.15) !important;
        border-color: #28a745;
    }
    
    .category-icon-placeholder {
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    
    .breadcrumb-item a {
        color: #28a745;
        text-decoration: none;
    }
</style>
@endsection