@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-500/20" style="background: linear-gradient(135deg, #10B981, #34D399);">
                <i class="bi bi-box-seam text-white text-4xl"></i>
            </div>
            <h2 class="font-extrabold text-3xl text-slate-900 tracking-tight">Lacak Pesanan</h2>
            <p class="text-slate-500 mt-2 max-w-sm mx-auto">Cek status pengiriman kerupuk pesanan Anda dengan mudah.</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.06)] overflow-hidden animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]" style="animation-delay: 0.1s;">
            <div class="p-8 sm:p-10">
                <form method="POST" action="{{ route('tracking.check') }}">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="tracking_number" class="block text-sm font-semibold text-slate-700 mb-2">Nomor Resi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-upc-scan text-slate-400"></i>
                            </div>
                            <input type="text" id="tracking_number" name="tracking_number"
                                   placeholder="Contoh: JP1234567890" required
                                   value="{{ old('tracking_number') }}"
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors">
                        </div>
                        <p class="mt-2 text-xs text-slate-400"><i class="bi bi-info-circle mr-1"></i>Masukkan nomor resi yang Anda terima via detail pesanan.</p>
                    </div>
                    
                    <div class="mb-8">
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Pembeli</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-envelope text-slate-400"></i>
                            </div>
                            <input type="email" id="email" name="email"
                                   placeholder="nama@email.com" required
                                   value="{{ old('email') }}"
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors">
                        </div>
                        <p class="mt-2 text-xs text-slate-400"><i class="bi bi-info-circle mr-1"></i>Email yang Anda gunakan saat checkout.</p>
                    </div>
                    
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all duration-200 active:scale-95">
                            <i class="bi bi-search"></i> Lacak Sekarang
                        </button>
                        <a href="{{ route('login') }}" class="w-full flex justify-center items-center bg-white border-2 border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50 font-medium py-3 rounded-full transition-all">
                            Login untuk lihat semua riwayat
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-6 text-center text-sm text-slate-400 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]" style="animation-delay: 0.2s;">
            Butuh bantuan? Hubungi CS kami di<br>
            <a href="mailto:krupukruzzz@gmail.com" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">krupukruzzz@gmail.com</a>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection