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
                        <div id="snap-container"></div>
                        
                        <script type="text/javascript"
                            src="https://app.{{ config('services.midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js"
                            data-client-key="{{ config('services.midtrans.client_key') }}">
                        </script>
                        
                        <script type="text/javascript">
                            window.snap.pay('{{ $snapToken }}', {
                                onSuccess: function(result){
                                    window.location.href = "{{ route('checkout.success') }}?order_id={{ $order->order_number }}";
                                },
                                onPending: function(result){
                                    alert("Menunggu pembayaran!");
                                    window.location.href = "{{ route('checkout.success') }}?order_id={{ $order->order_number }}";
                                },
                                onError: function(result){
                                    alert("Pembayaran gagal!");
                                    window.location.href = "{{ route('checkout.index') }}";
                                },
                                onClose: function(){
                                    alert("Popup ditutup tanpa menyelesaikan pembayaran!");
                                }
                            });
                        </script>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Token pembayaran tidak tersedia. Silakan hubungi admin.
                        </div>
                        <a href="{{ route('checkout.success') }}?order_id={{ $order->order_number }}" 
                           class="btn btn-primary">
                            Lanjutkan Tanpa Pembayaran (Testing)
                        </a>
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