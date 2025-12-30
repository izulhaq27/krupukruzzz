@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2">Selesaikan Pembayaran</h2>
                <p class="text-muted">Pilih metode pembayaran yang Anda inginkan</p>
                
                <div class="card border-0 shadow-sm d-inline-block px-4 py-3 mt-2" style="background: rgba(40, 167, 69, 0.08);">
                    <span class="text-muted small text-uppercase fw-bold ls-1 d-block mb-1">Total Tagihan</span>
                    <h3 class="text-success fw-bold mb-0">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h3>
                </div>
                <div class="mt-3">
                    <span class="badge bg-light text-dark border fw-normal px-3 py-2">Order ID: <span class="fw-bold">#{{ $order->order_number }}</span></span>
                </div>
            </div>

            @if($snapToken)
            <!-- Automated Payment Card -->
            <div class="card border-0 shadow-sm mb-4 overflow-hidden payment-card ring-hover">
                <div class="card-body p-4 text-center">
                    <div class="mb-4">
                        <div class="icon-circle bg-success-subtle text-success mx-auto mb-3">
                            <i class="bi bi-lightning-charge-fill fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Pembayaran Otomatis</h5>
                        <p class="text-muted small px-4">QRIS, E-Wallet (GoPay, OVO, ShopeePay), Virtual Account Bank, & Kartu Kredit.</p>
                    </div>
                    
                    <button id="pay-button" class="btn btn-success w-100 py-3 rounded-3 fw-bold shadow-sm hover-elevate">
                        <i class="bi bi-wallet2 me-2"></i> Bayar Sekarang (Otomatis)
                    </button>
                    <div class="mt-3 text-muted x-small">
                        <small><i class="bi bi-shield-check me-1"></i> Pembayaran aman, instan & terverifikasi otomatis</small>
                    </div>
                </div>
            </div>

            <div class="position-relative text-center my-4">
                <hr class="text-muted opacity-25">
                <span class="position-absolute top-50 start-50 translate-middle bg-light px-3 text-muted small fw-medium text-uppercase">
                    Atau
                </span>
            </div>
            @endif

            <!-- Manual Transfer Card -->
            <div class="card border-0 shadow-sm mb-4 payment-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-circle bg-primary-subtle text-primary me-3" style="width: 45px; height: 45px;">
                            <i class="bi bi-bank fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Transfer Manual</h5>
                            <small class="text-muted">Transfer ke rekening bank & upload bukti secara manual</small>
                        </div>
                    </div>

                    <div class="bank-account-card p-3 rounded-3 mb-4 bg-light border border-secondary border-opacity-10 position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary mb-2">Bank Jago</span>
                                <h4 class="font-monospace mb-1 text-dark" id="rek-number">100641390135</h4>
                                <p class="mb-0 small text-uppercase fw-bold text-muted">A.N. Acmad Machrus Ali</p>
                            </div>
                            <button onclick="copyToClipboard('100641390135')" class="btn btn-sm btn-white border shadow-sm text-primary" data-bs-toggle="tooltip" title="Salin No. Rekening">
                                <i class="bi bi-files"></i> Salin
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('orders.set-manual', $order->order_number) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary w-100 py-2 fw-medium border-2 rounded-3">
                            Lanjut Transfer Manual <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>

            @if(!$snapToken)
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-3 fs-4"></i>
                    <div>
                        Layanan pembayaran otomatis (Midtrans) sedang tidak tersedia saat ini. Silakan gunakan metode transfer manual.
                    </div>
                </div>
            @endif
            
            <div class="text-center mt-5 mb-4">
                <a href="{{ route('checkout.index') }}" class="text-decoration-none text-muted fw-medium small hover-underline">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke detail pesanan
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hover-elevate {
        transition: all 0.2s ease;
    }
    .hover-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(40, 167, 69, 0.2) !important;
    }
    .hover-underline:hover {
        text-decoration: underline !important;
        color: var(--primary-green) !important;
    }
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-subtle { background-color: rgba(40, 167, 69, 0.1); }
    .ls-1 { letter-spacing: 1px; }
    .x-small { font-size: 0.75rem; }
    .payment-card {
        border-radius: 16px;
        transition: box-shadow 0.3s ease;
    }
    .ring-hover:hover {
        box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.1) !important;
    }
    .btn-white {
        background: white;
    }
    .btn-white:hover {
        background: #f8f9fa;
        color: var(--primary-green) !important;
    }
</style>

@if($snapToken)
<script type="text/javascript"
    src="https://app.{{ config('services.midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}">
</script>

<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    if (payButton) {
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    console.log(result);
                    window.location.href = "{{ route('checkout.success') }}?order_id={{ $order->order_number }}";
                },
                onPending: function(result){
                    console.log(result);
                },
                onError: function(result){
                    console.log(result);
                    alert("Pembayaran gagal atau terjadi kesalahan.");
                },
                onClose: function(){
                    console.log('customer closed the popup without finishing the payment');
                }
            });
        });
    }
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Check if toast container exists, if not create one
            let toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 start-50 translate-middle-x p-3';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-check-circle me-2"></i> Nomor rekening berhasil disalin!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
            // Fallback
            alert("Nomor rekening: " + text);
        });
    }
</script>
@endif
@endsection