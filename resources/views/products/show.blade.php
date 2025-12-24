@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Product Image --}}
        <div class="col-md-6 mb-4">
            @if($product->image)
                @if(str_starts_with($product->image, 'http'))
                    <img src="{{ $product->image }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
                @endif
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded shadow" style="height: 400px;">
                    <div class="text-center">
                        <h1 class="display-1"></h1>
                        <h3>{{ $product->name }}</h3>
                    </div>
                </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="col-md-6">
            <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
            <span class="badge bg-success mb-3">Tersedia</span>
            
            <h2 class="text-danger mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
            <p class="text-muted mb-4">
                <strong>Stok:</strong> {{ $product->stock }} unit
            </p>
            
            <hr>
            
            <h5 class="fw-bold mb-3">Deskripsi Produk</h5>
            <p class="text-muted">{{ $product->description }}</p>
            
            <div class="d-grid gap-2 mt-4">
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Tambah ke Keranjang
                    </button>
                </form>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg">
                    Kembali ke Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection