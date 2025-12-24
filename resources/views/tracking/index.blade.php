@extends('layouts.app')

@section('title', 'Lacak Pesanan - KrupuKruzz')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Lacak Pesanan Anda</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('tracking.check') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">
                                <i class="bi bi-upc-scan"></i> Nomor Resi
                            </label>
                            <input type="text" class="form-control form-control-lg" 
                                   id="tracking_number" name="tracking_number" 
                                   placeholder="No Resi " required
                                   value="{{ old('tracking_number') }}">
                            <div class="form-text">
                                Masukkan nomor resi yang Anda terima via email/SMS.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email Anda
                            </label>
                            <input type="email" class="form-control form-control-lg" 
                                    id="email" name="email" 
                                    placeholder="Email" required
                                    value="{{ old('email') }}">
                            <div class="form-text">
                                Email yang Anda gunakan saat order.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-search"></i> Lacak Sekarang
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-person"></i> Login untuk lihat semua pesanan
                            </a>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i>
                            Butuh bantuan? Hubungi: 
                            <a href="mailto:krupukruzzz@gmail.com">krupukruzzz@gmail.com</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection