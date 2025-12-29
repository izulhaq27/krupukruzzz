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
                    
                    @if($snapToken)
                        <!-- Midtrans Snap -->
                        <div id="snap-container"></div>
                        
                        <script type="text/javascript"
                            src="https://app.{{ config('services.midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js"
                            data-client-key="{{ config('services.midtrans.client_key') }}">
                        </script>
                        
                        <script type="text/javascript">
                            window.snap.pay('{{ $snapToken }}', {
                                onSuccess: function(result){
                                    console.log(result);
                                    window.location.href = "{{ route('checkout.success') }}?order_id={{ $order->order_number }}";
                                },
                                onPending: function(result){
                                    console.log(result);
                                    window.location.href = "{{ route('checkout.success') }}?order_id={{ $order->order_number }}";
                                },
                                onError: function(result){
                                    console.log(result);
                                    alert("Pembayaran gagal atau dibatalkan!");
                                    window.location.href = "{{ route('products.index') }}";
                                },
                                onClose: function(){
                                    /* Pergi ke halaman dashboard pesanan jika user menutup popup */
                                    window.location.href = "{{ route('orders.index') }}";
                                }
                            });
                        </script>

                        <div class="hr-text my-4">ATAU</div>
                    @endif

                    <!-- Manual Bank Transfer Section -->
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-university"></i> Transfer Bank Manual</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-start mb-2">Silakan transfer ke rekening berikut:</p>
                            <div class="bg-light p-3 rounded mb-3 text-start border-start border-primary border-4">
                                <p class="mb-1 text-primary fw-bold"><i class="fas fa-university"></i> Rekening Tujuan:</p>
                                <p class="mb-1"><strong>Bank BRI</strong></p>
                                <p class="mb-1">Nomor Rekening: <strong class="fs-5 text-dark">1234-5678-9012-345</strong></p>
                                <p class="mb-0">Atas Nama: <strong>KrupuKruzzz UMKM</strong></p>
                            </div>
                            
                            <form action="{{ route('orders.set-manual', $order->order_number) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">
                                    Pilih Transfer Manual & Upload Bukti
                                </button>
                            </form>
                        </div>
                    </div>

                    @if(!$snapToken)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Layanan pembayaran otomatis (Midtrans) sedang tidak tersedia.
                        </div>
                    @endif
                    
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