@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-tags text-primary"></i>
            Manajemen Kategori
        </h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </a>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Alert Error -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Kategori Cards -->
    <div class="row">
        @forelse($categories as $category)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    
                    <!-- Image -->
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             class="card-img-top" 
                             alt="{{ $category->name }}" 
                             style="height: 200px; object-fit: cover; border-radius: 1rem 1rem 0 0;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="height: 200px; border-radius: 1rem 1rem 0 0;">
                            <i class="bi bi-image" style="font-size: 4rem; color: #ddd;"></i>
                        </div>
                    @endif
                    
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold mb-0">{{ $category->name }}</h5>
                            @if($category->is_active)
                                <span class="badge bg-success rounded-pill">Aktif</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Nonaktif</span>
                            @endif
                        </div>
                        
                        <p class="text-muted small mb-2">
                            <i class="bi bi-link-45deg"></i>{{ $category->slug }}
                        </p>
                        
                        <p class="card-text text-muted">
                            {{ Str::limit($category->description, 100) }}
                        </p>
                        
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-box-seam me-2 text-muted"></i>
                            <span class="badge bg-info rounded-pill">{{ $category->products_count }} Produk</span>
                        </div>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="card-footer bg-white border-0 pb-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="btn btn-warning btn-sm flex-fill rounded-3">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="flex-fill"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100 rounded-3">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
                        <h5 class="text-muted mt-3">Belum ada kategori</h5>
                        <p class="text-muted">Mulai dengan menambahkan kategori pertama Anda</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-3 mt-2">
                            <i class="bi bi-plus-circle"></i> Tambah Kategori
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection