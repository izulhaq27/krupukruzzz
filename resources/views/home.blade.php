@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-lg animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.06)] text-center p-10 md:p-14">
            
            <!-- Avatar/Icon -->
            <div class="mb-8">
                <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto shadow-sm animate-[scaleIn_0.5s_cubic-bezier(0.34,1.56,0.64,1)_forwards]">
                    <i class="bi bi-person-check text-5xl text-emerald-500 leading-none"></i>
                </div>
            </div>

            <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 tracking-tight mb-3">
                Selamat Datang, {{ Auth::user()->name }}! 👋
            </h2>
            
            <p class="text-slate-500 leading-relaxed mb-10">
                Anda berhasil masuk. Ingin melanjutkan berbelanja atau mengecek status pesanan Anda?
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('products.index') }}" class="flex-1 flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 px-5 rounded-full shadow-sm shadow-emerald-500/20 transition-all duration-200 active:scale-95">
                    <i class="bi bi-shop"></i> Mulai Belanja
                </a>
                <a href="{{ route('orders.index') }}" class="flex-1 flex justify-center items-center gap-2 bg-white border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-600 font-bold py-4 px-5 rounded-full transition-all duration-200 active:scale-95">
                    <i class="bi bi-box-seam"></i> Cek Pesanan
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scaleIn {
        0%   { transform: scale(0); opacity: 0; }
        60%  { transform: scale(1.08); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
