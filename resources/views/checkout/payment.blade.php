@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">💳 Pembayaran</h4>
                </div>
                <div class="card-body text-center">
                    <h5 class="mb-3">Order #{{ $order->order_number }}</h5>
                    <p class="text-muted">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    
                    <div class="alert alert-info border-0 shadow-sm rounded-4 text-start mb-4">
                        <h6 class="fw-bold"><i class="bi bi-info-circle me-2"></i> Instruksi Pembayaran:</h6>
                        <p class="small mb-0">Silakan transfer total pembayaran ke salah satu rekening di bawah ini, kemudian unggah bukti transfer Anda.</p>
                    </div>

                    <div class="row g-3 mb-4">
                        @foreach($banks as $bank)
                        <div class="col-md-6">
                            <div class="p-3 border rounded-4 bg-light text-start shadow-sm h-100">
                                <div class="small text-muted fw-bold mb-1">{{ $bank['name'] }}</div>
                                <div class="h5 fw-bold text-primary mb-1">{{ $bank['number'] }}</div>
                                <div class="small fw-semibold text-dark">a/n {{ $bank['holder'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                        <div class="card-body p-4 text-start">
                            <h6 class="fw-bold mb-3"><i class="bi bi-cloud-upload me-2"></i> Unggah Bukti Transfer</h6>
                            
                            <form action="{{ route('checkout.upload-proof', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Gunakan Bank:</label>
                                    <select name="bank_name" class="form-select rounded-3" required>
                                        <option value="">-- Pilih Bank --</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank['name'] }}">{{ $bank['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Pilih File Bukti (Foto/Screenshot):</label>
                                    <input type="file" name="payment_proof" class="form-control rounded-3" accept="image/*" required>
                                    <small class="text-muted">Format: JPG, PNG • Maksimal 2MB</small>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold py-2 shadow-sm">
                                    <i class="bi bi-send-check me-2"></i> Konfirmasi Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('checkout.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection