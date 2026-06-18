@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header + Progress -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-2">
                <a href="{{ route('cart.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">Keranjang</a>
                <i class="bi bi-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-800 font-bold">Pengiriman</span>
            </nav>
            <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 tracking-tight">Detail Pengiriman</h2>
        </div>
        <!-- Progress Steps -->
        <div class="hidden md:flex items-center gap-3 text-sm">
            <div class="flex items-center gap-2 font-bold text-emerald-500">
                <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold">1</div>
                Pengiriman
            </div>
            <div class="w-8 h-0.5 bg-slate-200"></div>
            <div class="flex items-center gap-2 font-medium text-slate-400">
                <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-xs font-bold">2</div>
                Pembayaran
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <!-- Left Column: Form -->
            <div class="flex-grow lg:w-2/3 space-y-6">
                <!-- Alamat Pengiriman -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                    <h5 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
                        <i class="bi bi-geo-alt text-emerald-500"></i> Alamat Pengiriman
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="shipping_name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Penerima <span class="text-red-500">*</span></label>
                            <input type="text" id="shipping_name" name="shipping_name" value="{{ auth()->user()->name }}" required placeholder="Masukkan nama lengkap"
                                   class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label for="shipping_phone" class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon/WA <span class="text-red-500">*</span></label>
                            <input type="text" id="shipping_phone" name="shipping_phone" value="{{ auth()->user()->phone }}" required placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors">
                        </div>
                        <div class="md:col-span-2">
                            <label for="shipping_address" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea id="shipping_address" name="shipping_address" rows="3" required placeholder="Nama jalan, gedung, no. rumah, RT/RW, kelurahan, kecamatan"
                                      class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors resize-none">{{ auth()->user()->address }}</textarea>
                            <p class="mt-2 text-xs text-slate-400"><i class="bi bi-info-circle mr-1"></i>Pastikan alamat ditulis selengkap mungkin.</p>
                        </div>
                    </div>
                </div>

                <!-- Kurir -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                    <h5 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
                        <i class="bi bi-truck text-emerald-500"></i> Pilih Kurir Pengiriman
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kurir <span class="text-red-500">*</span></label>
                            <select name="shipping_courier" id="shipping_courier" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors">
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE Express</option>
                                <option value="jnt">J&T Express</option>
                                <option value="sicepat">SiCepat Ekspres</option>
                                <option value="pos">Pos Indonesia</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Layanan <span class="text-red-500">*</span></label>
                            <select name="shipping_service" id="shipping_service" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors">
                                <option value="">Pilih Layanan</option>
                                <option value="reg">Reguler (2-3 hari)</option>
                                <option value="yes">YES / Next Day (1 hari)</option>
                                <option value="eco">Ekonomi (4-7 hari)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                    <h5 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-pencil-square text-emerald-500"></i> Catatan Pesanan 
                        <span class="text-sm font-normal text-slate-400">(Opsional)</span>
                    </h5>
                    <textarea id="notes" name="notes" rows="3" placeholder="Contoh: Tolong packing yang aman, kerupuk mudah hancur."
                              class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors resize-none"></textarea>
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="lg:w-1/3 shrink-0">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm sticky top-24 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h5 class="font-extrabold text-lg text-slate-900 m-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="p-4 bg-slate-50/30 max-h-56 overflow-y-auto divide-y divide-slate-100">
                        @foreach($cart as $id => $item)
                            <div class="flex gap-3 py-3 {{ !$loop->last ? '' : '' }}">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-12 h-12 rounded-xl object-cover shrink-0 border border-slate-100" alt="{{ $item['name'] }}">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shrink-0 border border-slate-200">
                                        <i class="bi bi-image text-slate-300"></i>
                                    </div>
                                @endif
                                <div class="flex-grow min-w-0">
                                    <h6 class="text-sm font-semibold text-slate-800 truncate mb-1">{{ $item['name'] }}</h6>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-slate-500">{{ $item['quantity'] }} x Rp{{ number_format($item['price'], 0, ',', '.') }}</span>
                                        <span class="text-sm font-bold text-slate-800">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between text-sm mb-3">
                            <span class="text-slate-500">Total Harga ({{ count($cart) }} barang)</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-6 pb-6 border-b border-slate-100">
                            <span class="text-slate-500">Ongkos Kirim</span>
                            <span class="text-xs font-medium px-2 py-1 bg-amber-50 text-amber-600 rounded-md">Dihitung selanjutnya</span>
                        </div>
                        <div class="flex justify-between items-end mb-8">
                            <strong class="text-slate-900 font-bold">Subtotal</strong>
                            <strong class="text-2xl text-emerald-500 font-extrabold leading-none">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all duration-200 active:scale-95">
                            Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection