@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-lg animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.06)] text-center p-8 md:p-12">
            
            <!-- Success Animation Icon -->
            <div class="mb-8">
                <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto animate-[scaleIn_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
                    <i class="bi bi-check-lg text-5xl text-emerald-500 leading-none"></i>
                </div>
            </div>

            <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 tracking-tight mb-3">Pesanan Berhasil Dibuat!</h2>
            
            <p class="text-slate-500 mb-8 leading-relaxed">
                Terima kasih telah berbelanja di KrupuKruzzz. Pesanan Anda telah kami terima dan sedang menunggu pembayaran.
            </p>

            <!-- Order Info Box -->
            <div class="bg-slate-50 rounded-2xl border border-dashed border-slate-300 p-5 mb-8 text-left">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <small class="text-slate-500 text-xs block mb-1 font-medium">No. Pesanan</small>
                        <span class="font-bold text-slate-800">{{ $order->order_number }}</span>
                    </div>
                    <div class="text-right">
                        <small class="text-slate-500 text-xs block mb-1 font-medium">Total Tagihan</small>
                        <span class="font-extrabold text-xl text-emerald-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-3">
                <a href="{{ route('orders.show', $order->order_number) }}" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all duration-200 active:scale-95">
                    <i class="bi bi-wallet2"></i> Lanjutkan Pembayaran
                </a>
                <a href="{{ route('products.index') }}" class="w-full flex justify-center items-center bg-white border-2 border-slate-200 hover:border-slate-300 text-slate-600 font-bold py-3 rounded-full transition-all duration-200 active:scale-95">
                    Kembali Berbelanja
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        60% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection