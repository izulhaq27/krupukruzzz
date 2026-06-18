@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header + Progress -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-2">
                <a href="{{ route('cart.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">Keranjang</a>
                <i class="bi bi-chevron-right text-[10px] text-slate-400"></i>
                <a href="{{ route('checkout.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">Pengiriman</a>
                <i class="bi bi-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-800 font-bold">Pembayaran</span>
            </nav>
            <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 tracking-tight">Pilih Pembayaran</h2>
        </div>
        <!-- Progress Steps -->
        <div class="hidden md:flex items-center gap-3 text-sm">
            <div class="flex items-center gap-2 font-medium text-emerald-500">
                <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs">
                    <i class="bi bi-check"></i>
                </div>
                Pengiriman
            </div>
            <div class="w-8 h-0.5 bg-emerald-400"></div>
            <div class="flex items-center gap-2 font-bold text-emerald-500">
                <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold">2</div>
                Pembayaran
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.process_payment') }}" method="POST">
        @csrf
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <!-- Left: Payment Options -->
            <div class="flex-grow lg:w-2/3 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                    <h5 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
                        <i class="bi bi-wallet2 text-emerald-500"></i> Metode Pembayaran
                    </h5>
                    <div class="space-y-4" x-data="{ selected: 'automatic' }">
                        <!-- Option 1: Automatic -->
                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_type" value="automatic" class="sr-only" x-model="selected" checked>
                            <div :class="selected === 'automatic' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-slate-300'"
                                 class="border-2 rounded-2xl p-5 flex items-center gap-4 transition-all duration-200">
                                <div :class="selected === 'automatic' ? 'bg-emerald-500 border-emerald-500' : 'bg-white border-slate-300'"
                                     class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-all">
                                    <div :class="selected === 'automatic' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                         class="w-2.5 h-2.5 rounded-full bg-white transition-all"></div>
                                </div>
                                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center shrink-0">
                                    <i class="bi bi-credit-card-2-front text-2xl text-emerald-500"></i>
                                </div>
                                <div>
                                    <h6 class="font-bold text-slate-800 mb-1">Pembayaran Otomatis (Midtrans)</h6>
                                    <p class="text-sm text-slate-500 m-0">VA BCA, Mandiri, BNI, BRI, GoPay, OVO, dll. Konfirmasi otomatis.</p>
                                </div>
                            </div>
                        </label>

                        <!-- Option 2: Manual Transfer -->
                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_type" value="manual_transfer" class="sr-only" x-model="selected">
                            <div :class="selected === 'manual_transfer' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-slate-300'"
                                 class="border-2 rounded-2xl p-5 flex items-center gap-4 transition-all duration-200">
                                <div :class="selected === 'manual_transfer' ? 'bg-emerald-500 border-emerald-500' : 'bg-white border-slate-300'"
                                     class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-all">
                                    <div :class="selected === 'manual_transfer' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"
                                         class="w-2.5 h-2.5 rounded-full bg-white transition-all"></div>
                                </div>
                                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center shrink-0">
                                    <i class="bi bi-bank text-2xl text-amber-500"></i>
                                </div>
                                <div>
                                    <h6 class="font-bold text-slate-800 mb-1">Transfer Bank Manual</h6>
                                    <p class="text-sm text-slate-500 m-0">Transfer ke rekening Bank Jago kami. Perlu konfirmasi manual.</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 mt-6 flex gap-3 items-start">
                        <i class="bi bi-shield-check text-emerald-500 text-xl mt-0.5"></i>
                        <div>
                            <strong class="text-emerald-800 text-sm block mb-1">Pembayaran Aman</strong>
                            <p class="text-xs text-slate-600 m-0">Semua transaksi di KrupuKruzzz dilindungi oleh enkripsi standar industri.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Summary -->
            <div class="lg:w-1/3 shrink-0">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm sticky top-24 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h5 class="font-extrabold text-lg text-slate-900 m-0">Ringkasan Pembayaran</h5>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between text-sm mb-3">
                            <span class="text-slate-500">Total Harga Barang</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-6 pb-6 border-b border-slate-100">
                            <span class="text-slate-500">Ongkos Kirim ({{ strtoupper($checkoutData['shipping_courier']) }})</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-end mb-8">
                            <strong class="text-slate-900 font-bold">Total Tagihan</strong>
                            <strong class="text-2xl text-emerald-500 font-extrabold leading-none">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all duration-200 active:scale-95">
                            <i class="bi bi-lock-fill"></i> Bayar Sekarang
                        </button>
                    </div>
                    <div class="px-6 pb-5 text-center">
                        <a href="{{ route('checkout.index') }}" class="text-sm font-medium text-slate-400 hover:text-slate-600 transition-colors">
                            <i class="bi bi-arrow-left mr-1"></i> Kembali ke Pengiriman
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection