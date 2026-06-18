@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-2">
                <a href="{{ route('orders.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">Pesanan Saya</a>
                <i class="bi bi-chevron-right text-[10px] text-slate-400"></i>
                <span class="text-slate-800 font-bold">Detail</span>
            </nav>
            <div class="flex items-center gap-3">
                <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 tracking-tight">Detail Pesanan</h2>
                <span class="bg-slate-100 text-slate-600 border border-slate-200 text-sm font-bold px-3 py-1 rounded-full">#{{ $order->order_number }}</span>
            </div>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('orders.index') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-white border-2 border-slate-200 text-slate-600 hover:bg-slate-50 font-bold px-5 py-2.5 rounded-full transition-all">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('orders.invoice', $order->order_number) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-white border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-bold px-5 py-2.5 rounded-full transition-all">
                <i class="bi bi-printer"></i> Invoice
            </a>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
        <!-- LEFT COLUMN -->
        <div class="flex-grow lg:w-2/3 space-y-6">
            <!-- STATUS TIMELINE -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <h5 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
                    <i class="bi bi-clock-history text-emerald-500"></i> Status Pesanan
                </h5>
                @php
                    $timeline = [
                        'pending'   => ['label' => 'Menunggu Pembayaran', 'icon' => 'bi-clock',         'desc' => 'Menunggu pembayaran dari Anda'],
                        'paid'      => ['label' => 'Pembayaran Diterima',  'icon' => 'bi-check-circle',  'desc' => 'Pembayaran telah dikonfirmasi'],
                        'processed' => ['label' => 'Pesanan Diproses',     'icon' => 'bi-gear',          'desc' => 'Pesanan sedang dipersiapkan'],
                        'shipped'   => ['label' => 'Pesanan Dikirim',      'icon' => 'bi-truck',         'desc' => $order->shipped_at ? 'Dikirim pada ' . $order->shipped_at->format('d M Y, H:i') : ''],
                        'completed' => ['label' => 'Pesanan Selesai',      'icon' => 'bi-check2-circle', 'desc' => $order->delivered_at ? 'Selesai pada ' . $order->delivered_at->format('d M Y, H:i') : ''],
                    ];
                    $statusIndex = array_keys($timeline);
                    $currentStatus = $order->status;
                @endphp
                <div class="relative ml-3 mt-4 pl-6 border-l-2 border-slate-200 space-y-6">
                    @foreach($timeline as $status => $info)
                        @php
                            $isActive = in_array($status, array_slice($statusIndex, 0, array_search($currentStatus, $statusIndex) + 1));
                            $isCurrent = $status == $currentStatus;
                        @endphp
                        <div class="relative">
                            <!-- Dot -->
                            <div class="absolute -left-[33px] top-0 w-6 h-6 rounded-full flex items-center justify-center border-2 transition-all
                                {{ $isCurrent ? 'bg-emerald-500 border-emerald-500 shadow-[0_0_0_4px_rgba(16,185,129,0.15)]' : ($isActive ? 'bg-white border-emerald-500' : 'bg-white border-slate-300') }}">
                                @if($isCurrent || $isActive)
                                    <i class="bi {{ $info['icon'] }} text-[10px] {{ $isCurrent ? 'text-white' : 'text-emerald-500' }}"></i>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                                @endif
                            </div>
                            <!-- Active line override -->
                            @if($isActive)
                                <div class="absolute -left-[33px] top-6 w-0.5 h-full bg-emerald-400 -ml-px z-10" style="display: none;"></div>
                            @endif
                            <h6 class="font-bold mb-1 {{ $isActive ? 'text-emerald-600' : 'text-slate-400' }}">{{ $info['label'] }}</h6>
                            @if($isActive && $info['desc'])
                                <p class="text-sm text-slate-500 m-0">{{ $info['desc'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ITEMS -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <h5 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
                    <i class="bi bi-bag-check text-emerald-500"></i> Daftar Produk
                </h5>
                <div class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 py-4">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-16 h-16 rounded-2xl object-cover border border-slate-100 shrink-0" alt="{{ $item->product_name }}">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center shrink-0 border border-slate-200">
                                    <i class="bi bi-image text-slate-300 text-xl"></i>
                                </div>
                            @endif
                            <div class="flex-grow">
                                <h6 class="font-bold text-slate-800 mb-1">{{ $item->product_name }}</h6>
                                @if($item->product_sku)
                                    <p class="text-xs text-slate-400 mb-2">SKU: {{ $item->product_sku }}</p>
                                @endif
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    <span class="font-bold text-slate-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="lg:w-1/3 shrink-0 space-y-6">
            <!-- INFO PENGIRIMAN -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <h5 class="font-bold text-lg text-slate-800 mb-5 flex items-center gap-2">
                    <i class="bi bi-truck text-emerald-500"></i> Info Pengiriman
                </h5>
                @if($order->shipping_courier)
                    <div class="space-y-4">
                        <div>
                            <small class="text-slate-400 text-xs font-medium block mb-1">Kurir & Layanan</small>
                            <span class="font-semibold text-slate-800 uppercase">{{ $order->shipping_courier }} - {{ $order->shipping_service ?? 'REG' }}</span>
                        </div>
                        @if($order->tracking_number)
                            <div class="bg-slate-50 rounded-2xl p-4 border border-dashed border-slate-300">
                                <small class="text-slate-400 text-xs font-medium block mb-2">No. Resi</small>
                                <div class="flex items-center justify-between gap-3">
                                    <span class="font-bold text-emerald-500 font-mono tracking-widest text-lg">{{ $order->tracking_number }}</span>
                                    @if($order->tracking_link)
                                        <a href="{{ $order->tracking_link }}" target="_blank" class="shrink-0 text-xs font-bold bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-100 px-3 py-1.5 rounded-full transition-colors">Lacak</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div>
                            <small class="text-slate-400 text-xs font-medium block mb-1">Alamat Penerima</small>
                            <span class="font-semibold text-slate-800 block">{{ $order->shipping_name ?? auth()->user()->name }}</span>
                            <span class="text-slate-600 text-sm mt-1 block leading-relaxed">{{ $order->shipping_address ?? auth()->user()->address }}</span>
                        </div>
                        @if($order->notes)
                            <div>
                                <small class="text-slate-400 text-xs font-medium block mb-1">Catatan Pesanan</small>
                                <span class="italic text-slate-700 text-sm">"{{ $order->notes }}"</span>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-slate-400 text-center py-4">Belum ada info pengiriman</p>
                @endif
            </div>

            <!-- RINGKASAN PEMBAYARAN -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h5 class="font-extrabold text-lg text-slate-900 m-0 flex items-center gap-2">
                        <i class="bi bi-wallet2 text-emerald-500"></i> Ringkasan Pembayaran
                    </h5>
                </div>
                <div class="p-6">
                    <div class="flex justify-between text-sm mb-3">
                        <span class="text-slate-500">Total Harga ({{ $order->items->sum('quantity') }} barang)</span>
                        <span class="font-semibold text-slate-800">Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                    </div>
                    @if($order->shipping_cost)
                        <div class="flex justify-between text-sm mb-4 pb-4 border-b border-slate-100">
                            <span class="text-slate-500">Ongkos Kirim</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-end mb-4">
                        <strong class="text-slate-900 font-bold">Total Tagihan</strong>
                        <strong class="text-2xl text-emerald-500 font-extrabold leading-none">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                    </div>
                    @if($order->payment_type)
                        <div class="bg-slate-50 rounded-xl p-4 mt-2">
                            <small class="text-slate-400 text-xs font-medium block mb-1">Metode Pembayaran</small>
                            <span class="font-bold text-slate-800">{{ $order->payment_type_label ?? ($order->payment_type == 'manual_transfer' ? 'Transfer Bank Manual' : 'Pembayaran Otomatis') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            @if($order->status == 'pending')
                @if($order->payment_type == 'manual_transfer')
                    <div class="bg-white rounded-3xl border-2 border-amber-500 p-6 shadow-sm">
                        <h6 class="font-bold text-amber-700 mb-4 flex items-center gap-2">
                            <i class="bi bi-upload"></i> Konfirmasi Pembayaran
                        </h6>
                        @if($order->payment_proof)
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl p-3 mb-4 flex items-center gap-2">
                                <i class="bi bi-check-circle"></i> Bukti terunggah. Menunggu konfirmasi.
                            </div>
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-32 object-cover rounded-xl mb-4 border border-slate-200">
                        @endif
                        <form action="{{ route('orders.upload-payment-proof', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-xs font-semibold text-slate-600 block mb-1">Bank Pengirim</label>
                                <input type="text" name="bank_name" class="w-full px-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors" placeholder="Contoh: BCA / Mandiri" value="{{ old('bank_name', $order->bank_name) }}" required>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600 block mb-1">Foto Bukti</label>
                                <input type="file" name="payment_proof" class="w-full px-4 py-2.5 text-sm bg-white border border-slate-200 rounded-xl transition-colors" accept="image/*" required>
                            </div>
                            <button type="submit" class="w-full flex justify-center items-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-full transition-all active:scale-95">
                                {{ $order->payment_proof ? 'Ganti Bukti' : 'Unggah Bukti' }}
                            </button>
                        </form>
                        <div class="bg-amber-50 rounded-2xl p-4 mt-4">
                            <small class="font-bold uppercase text-amber-700 block mb-2 tracking-wide text-xs">Transfer ke:</small>
                            <span class="block font-semibold text-slate-800">Bank Jago</span>
                            <span class="block text-2xl font-extrabold text-slate-900 font-mono my-1 tracking-wider">100641390135</span>
                            <span class="block text-sm text-slate-600">a.n Achmad Machrus Ali</span>
                        </div>
                    </div>
                @endif
                <div class="space-y-3">
                    <form action="{{ route('orders.pay', $order->order_number) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all active:scale-95" onclick="return confirm('Lanjutkan pembayaran otomatis via Midtrans?')">
                            <i class="bi bi-credit-card"></i> {{ $order->payment_type == 'manual_transfer' ? 'Ganti ke Otomatis' : 'Bayar Sekarang' }}
                        </button>
                    </form>
                    <form action="{{ route('orders.cancel', $order->order_number) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center bg-white border-2 border-red-300 text-red-500 hover:bg-red-50 font-bold py-3 rounded-full transition-all active:scale-95" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
            @endif

            @if($order->status == 'shipped')
                <form action="{{ route('orders.confirm-received', $order->order_number) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all active:scale-95" onclick="return confirm('Konfirmasi bahwa pesanan sudah Anda terima dengan baik?')">
                        <i class="bi bi-box-seam"></i> Konfirmasi Pesanan Diterima
                    </button>
                </form>
            @endif

            @if($order->status == 'completed')
                <div class="bg-emerald-50 border border-dashed border-emerald-200 rounded-3xl p-6 text-center mb-4">
                    <i class="bi bi-emoji-smile text-5xl text-emerald-400"></i>
                    <h6 class="font-bold mt-3 mb-1 text-emerald-700">Pesanan Selesai</h6>
                    <p class="text-sm text-emerald-600">Terima kasih telah berbelanja!</p>
                </div>
                <form action="{{ route('orders.reorder', $order->order_number) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all active:scale-95">
                        <i class="bi bi-arrow-repeat"></i> Pesan Lagi
                    </button>
                </form>
            @endif

            @if($order->status == 'cancelled')
                <div class="bg-red-50 border border-dashed border-red-200 rounded-3xl p-6 text-center mb-4">
                    <i class="bi bi-x-circle text-5xl text-red-400"></i>
                    <h6 class="font-bold mt-3 mb-1 text-red-700">Pesanan Dibatalkan</h6>
                </div>
                <a href="{{ route('products.index') }}" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all active:scale-95">
                    <i class="bi bi-shop"></i> Belanja Lagi
                </a>
            @endif
        </div>
    </div>
</div>
@endsection