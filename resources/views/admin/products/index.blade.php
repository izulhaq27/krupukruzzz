@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color: #1e293b;">Kelola Produk</h4>
        <p class="text-muted mb-0 small">Total {{ $products->count() }} produk</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn fw-bold" 
       style="background: #10b981; color: white; border: none; border-radius: 8px; padding: 8px 16px;">
        <i class="bi bi-plus-circle me-1"></i> Tambah Produk
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 10px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th class="border-0" style="padding: 16px; color: #64748b; width: 60px;">NO</th>
                        <th class="border-0" style="padding: 16px; color: #64748b;">Nama Produk</th>
                        <th class="border-0" style="padding: 16px; color: #64748b;">Kategori</th>
                        <th class="border-0" style="padding: 16px; color: #64748b; width: 150px;">Harga</th>
                        <th class="border-0" style="padding: 16px; color: #64748b; width: 100px;">Stok</th>
                        <th class="border-0 text-center" style="padding: 16px; color: #64748b; width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr class="border-bottom">
                        <td style="padding: 16px; color: #475569;">
                            <span class="badge" style="background: #f1f5f9; color: #334155;">
                                {{ $loop->iteration }}
                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    @if($p->image)
                                    <div style="width: 40px; height: 40px; border-radius: 6px; overflow: hidden; background: #eee;">
                                        <img src="{{ asset('storage/' . $p->image) }}" 
                                             alt="{{ $p->name }}"
                                             style="width: 100%; height: 100%; object-fit: cover;"
                                             loading="lazy">
                                    </div>
                                    @else
                                    <div style="width: 40px; height: 40px; border-radius: 6px; background: #f1f5f9; 
                                                display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium" style="color: #1e293b;">{{ $p->name }}</div>
                                    <small class="text-muted" style="font-size: 0.85rem;">
                                        {{ Str::limit($p->description, 50) }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 16px;">
                            @foreach($p->categories as $category)
                                <span class="badge bg-light text-dark">{{ $category->name }}</span>
                            @endforeach
                        </td>
                        <td style="padding: 16px; color: #10b981; font-weight: 600;">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </td>
                        <td style="padding: 16px;">
                            <span class="badge" style="
                                background: {{ $p->stock > 0 ? '#d1fae5' : '#fee2e2' }};
                                color: {{ $p->stock > 0 ? '#065f46' : '#991b1b' }};
                                padding: 4px 12px;
                                border-radius: 20px;
                                font-weight: 500;
                            ">
                                {{ $p->stock > 0 ? $p->stock . ' pcs' : 'Stok Habis' }}
                            </span>
                        </td>
                        <td style="padding: 16px;">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.products.edit', $p->id) }}" 
                                   class="btn btn-sm" 
                                   style="
                                        background: #fbbf24;
                                        color: #000;
                                        border: none;
                                        border-radius: 6px;
                                        padding: 6px 12px;
                                        font-size: 0.85rem;
                                   ">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" 
                                            style="
                                                background: #ef4444;
                                                color: white;
                                                border: none;
                                                border-radius: 6px;
                                                padding: 6px 12px;
                                                font-size: 0.85rem;
                                            ">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($products->isEmpty())
<div class="text-center py-5">
    <div class="mb-3">
        <i class="bi bi-box-seam display-4" style="color: #cbd5e1;"></i>
    </div>
    <h5 class="text-muted">Belum ada produk</h5>
    <p class="text-muted small mb-3">Mulai dengan menambahkan produk pertama</p>
    <a href="{{ route('admin.products.create') }}" class="btn" 
       style="background: #10b981; color: white; border-radius: 8px;">
        <i class="bi bi-plus-circle me-1"></i> Tambah Produk Pertama
    </a>
</div>
@endif

<style>
    .table > :not(caption) > * > * {
        border-bottom: 1px solid #f1f5f9;
    }
    
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.85rem;
        }
        
        .table th, 
        .table td {
            padding: 12px 8px !important;
        }
        
        .btn {
            padding: 5px 10px !important;
            font-size: 0.8rem !important;
        }
        
        .d-flex.gap-2 {
            gap: 4px !important;
        }
    }
</style>
@endsection
</div>