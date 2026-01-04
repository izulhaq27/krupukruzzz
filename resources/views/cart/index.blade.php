@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4" style="color: #28a745;">
        <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
    </h2>
    
    @if(empty($cart))
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-cart-x display-1 text-muted"></i>
            </div>
            <h3 class="fw-bold" style="color: #28a745;">Keranjang Kosong</h3>
            <p class="text-muted">Belum ada produk di keranjang Anda</p>
            <a href="{{ route('products.index') }}" class="btn btn-success btn-lg mt-3">
                <i class="bi bi-bag-plus me-2"></i>Mulai Belanja
            </a>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0" style="
                    border-radius: 12px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                ">
                    <div class="card-body p-4">
                        @foreach($cart as $id => $item)
                            <div class="row align-items-center mb-4 pb-4 border-bottom">
                                <!-- Image -->
                                <div class="col-md-2 col-4 mb-3 mb-md-0">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                        class="img-fluid rounded" 
                                        alt="{{ $item['name'] }}"
                                        style="height: 80px; width: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-light text-center py-3 rounded">
                                            <span style="font-size: 2rem;"></span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Info -->
                                <div class="col-md-3 col-8 mb-3 mb-md-0">
                                    <h6 class="fw-bold mb-2" style="color: #333;">{{ $item['name'] }}</h6>
                                    <p class="fw-semibold mb-0" style="color: #28a745; font-size: 1.1rem;">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <!-- Quantity -->
                                <div class="col-md-3 col-6 mb-3 mb-md-0">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm" style="width: 120px;">
                                            <button class="btn btn-outline-secondary" type="button" onclick="decrementQty(this)" style="
                                                border-color: #28a745;
                                                color: #28a745;
                                            ">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   class="form-control text-center qty-input">
                                            <button class="btn btn-outline-secondary" type="button" onclick="incrementQty(this)" style="
                                                border-color: #28a745;
                                                color: #28a745;
                                            ">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <button type="submit" class="btn btn-sm" style="
                                            background: #28a745;
                                            color: white;
                                        ">
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="col-md-3 col-4 text-md-end">
                                    <strong class="fs-6" style="color: #28a745;">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </strong>
                                </div>
                                
                                <!-- Remove -->
                                <div class="col-md-1 col-2 text-end">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Hapus produk dari keranjang?')"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Continue Shopping -->
                <div class="mt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-success" style="
                        border-color: #28a745;
                        color: #28a745;
                    ">
                        <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                    </a>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0" style="
                    border-radius: 12px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                ">
                    <div class="card-header text-white" style="
                        background: #28a745;
                        border-radius: 12px 12px 0 0;
                        padding: 1rem;
                    ">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-receipt me-2"></i>Ringkasan Belanja
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Subtotal ({{ count($cart) }} item)</span>
                            <span class="fw-semibold" style="color: #28a745;">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Ongkos Kirim</span>
                            <span style="color: #28a745; font-weight: 500;">
                                <i class="bi bi-check-circle-fill me-2"></i>GRATIS
                            </span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong class="fs-5" style="color: #333;">Total Bayar</strong>
                            <strong class="fs-4" style="color: #28a745;">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </strong>
                        </div>
                        
                        @auth
                            <div class="d-grid">
                                <a href="{{ route('checkout.index') }}" class="btn btn-lg" style="
                                    background: #28a745;
                                    color: white;
                                    border-radius: 8px;
                                    font-weight: 600;
                                ">
                                    <i class="bi bi-credit-card me-2"></i>Checkout Sekarang
                                </a>
                            </div>
                        @else
                            <div class="alert mb-3" style="
                                background: rgba(40, 167, 69, 0.1);
                                border-left: 4px solid #28a745;
                                color: #155724;
                            ">
                                <i class="bi bi-info-circle"></i>
                                <small class="d-block mt-1">Silakan login terlebih dahulu untuk melakukan checkout</small>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('login') }}" class="btn btn-lg" style="
                                    background: #28a745;
                                    color: white;
                                    border-radius: 8px;
                                    font-weight: 600;
                                ">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-success" style="
                                    border-color: #28a745;
                                    color: #28a745;
                                    border-radius: 8px;
                                    font-weight: 500;
                                ">
                                    <i class="bi bi-person-plus me-2"></i>Daftar
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function incrementQty(button) {
        const input = button.parentElement.querySelector('.qty-input');
        input.value = parseInt(input.value) + 1;
    }
    
    function decrementQty(button) {
        const input = button.parentElement.querySelector('.qty-input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
@endsection