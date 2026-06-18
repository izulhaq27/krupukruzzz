@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 tracking-tight flex items-center gap-3">
                <i class="bi bi-box-seam text-emerald-500"></i> Pesanan Saya
            </h2>
            <p class="text-slate-500 text-sm mt-1">Kelola dan lacak semua pesanan Anda</p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <a href="{{ route('products.index') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-5 py-2.5 rounded-full transition-all active:scale-95">
                <i class="bi bi-plus-circle"></i> Belanja
            </a>
            <form action="{{ route('logout') }}" method="POST" class="flex-1 md:flex-none">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-white border-2 border-red-300 text-red-500 hover:bg-red-50 font-bold px-5 py-2.5 rounded-full transition-all active:scale-95">
                    <i class="bi bi-box-arrow-right md:hidden"></i>
                    <span class="hidden md:inline">Logout</span>
                    <span class="md:hidden">Keluar</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Filter Status Pills -->
    <div class="flex gap-2 overflow-x-auto pb-3 mb-6 scrollbar-hide">
        @php
            $totalAll = auth()->user()->orders()->count();
            $totalPending = auth()->user()->pendingOrders()->count();
            $totalProcessed = auth()->user()->orders()->where('status', 'processed')->count();
            $totalShipped = auth()->user()->orders()->where('status', 'shipped')->count();
            $totalCompleted = auth()->user()->completedOrders()->count();
        @endphp
        <a href="{{ route('orders.index') }}" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-sm transition-all {{ !request('status') ? 'bg-emerald-500 text-white shadow-sm shadow-emerald-500/20' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
            Semua <span class="{{ !request('status') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }} text-xs font-bold px-2 py-0.5 rounded-full">{{ $totalAll }}</span>
        </a>
        <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-sm transition-all {{ request('status') == 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
            Menunggu Bayar <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ request('status') == 'pending' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $totalPending }}</span>
        </a>
        <a href="{{ route('orders.index', ['status' => 'processed']) }}" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-sm transition-all {{ request('status') == 'processed' ? 'bg-blue-500 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
            Diproses <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ request('status') == 'processed' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $totalProcessed }}</span>
        </a>
        <a href="{{ route('orders.index', ['status' => 'shipped']) }}" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-sm transition-all {{ request('status') == 'shipped' ? 'bg-sky-500 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
            Dikirim <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ request('status') == 'shipped' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $totalShipped }}</span>
        </a>
        <a href="{{ route('orders.index', ['status' => 'completed']) }}" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold text-sm transition-all {{ request('status') == 'completed' ? 'bg-slate-800 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:border-slate-300' }}">
            Selesai <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ request('status') == 'completed' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $totalCompleted }}</span>
        </a>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
            @foreach($orders as $order)
            @php
                $statusConfig = [
                    'pending'   => ['bg' => 'bg-amber-100 text-amber-800',  'icon' => 'bi-clock',             'label' => 'Menunggu Pembayaran'],
                    'paid'      => ['bg' => 'bg-sky-100 text-sky-800',      'icon' => 'bi-check-circle',      'label' => 'Dibayar'],
                    'processed' => ['bg' => 'bg-blue-100 text-blue-800',    'icon' => 'bi-gear',              'label' => 'Diproses'],
                    'shipped'   => ['bg' => 'bg-emerald-100 text-emerald-800','icon' => 'bi-truck',           'label' => 'Dikirim'],
                    'completed' => ['bg' => 'bg-slate-100 text-slate-700',  'icon' => 'bi-check2-circle',     'label' => 'Selesai'],
                    'cancelled' => ['bg' => 'bg-red-100 text-red-700',      'icon' => 'bi-x-circle',          'label' => 'Dibatalkan'],
                    'failed'    => ['bg' => 'bg-red-100 text-red-700',      'icon' => 'bi-exclamation-triangle','label' => 'Gagal'],
                ];
                $cfg = $statusConfig[$order->status] ?? ['bg' => 'bg-slate-100 text-slate-700', 'icon' => 'bi-question', 'label' => $order->status];
            @endphp
            <div class="animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards] opacity-0" style="animation-delay: {{ $loop->iteration * 0.08 }}s;">
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col h-full hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-500/10 hover:border-emerald-100 transition-all duration-300 overflow-hidden">
                    <!-- Order Header -->
                    <div class="flex justify-between items-start p-5 border-b border-slate-100 bg-slate-50/50">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-1">No. Pesanan</span>
                            <span class="font-bold text-slate-800">{{ $order->order_number }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block mb-1">Tanggal</span>
                            <span class="text-slate-600 text-sm font-medium">{{ $order->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="p-5 flex-grow">
                        <!-- Status -->
                        <div class="mb-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold {{ $cfg['bg'] }}">
                                <i class="bi {{ $cfg['icon'] }}"></i> {{ $cfg['label'] }}
                            </span>
                        </div>

                        <!-- Items Preview -->
                        <div class="space-y-3">
                            @if($order->items && $order->items->count() > 0)
                                @foreach($order->items->take(2) as $item)
                                    <div class="flex items-center gap-3">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 rounded-xl object-cover bg-slate-100 shrink-0 border border-slate-100">
                                        @else
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                                                <i class="bi bi-image text-slate-300"></i>
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-grow">
                                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $item->product_name ?? 'Produk' }}</p>
                                            <p class="text-xs text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                @if($order->items->count() > 2)
                                    <p class="text-xs text-center text-slate-400 font-medium py-2 rounded-lg bg-slate-50">
                                        + {{ $order->items->count() - 2 }} produk lainnya
                                    </p>
                                @endif
                            @else
                                <p class="text-sm text-slate-400">Tidak ada detail item</p>
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-5 border-t border-slate-100">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-slate-500 font-medium">Total Belanja</span>
                            <span class="font-bold text-emerald-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('orders.show', $order->order_number) }}" class="flex-1 flex items-center justify-center bg-white border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-bold py-2.5 rounded-xl text-sm transition-all active:scale-95">
                                Detail
                            </a>
                            @if($order->status == 'pending')
                                <a href="{{ route('orders.show', $order->order_number) }}" class="flex-1 flex items-center justify-center bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2.5 rounded-xl text-sm transition-all active:scale-95">
                                    Bayar
                                </a>
                            @endif
                            @if($order->status == 'shipped')
                                <a href="{{ $order->tracking_link ?? '#' }}" target="_blank" class="flex-1 flex items-center justify-center bg-sky-500 hover:bg-sky-600 text-white font-bold py-2.5 rounded-xl text-sm transition-all active:scale-95">
                                    Lacak
                                </a>
                            @endif
                            @if(in_array($order->status, ['cancelled', 'failed']))
                                <form action="{{ route('orders.destroy', $order->order_number) }}" method="POST" onsubmit="return confirm('Hapus riwayat pesanan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-10">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <div class="text-slate-200 mb-6">
                <i class="bi bi-receipt text-7xl"></i>
            </div>
            <h3 class="font-bold text-2xl text-slate-800 mb-3">Belum Ada Pesanan</h3>
            <p class="text-slate-500 max-w-sm mx-auto mb-8">Anda belum memiliki riwayat pesanan. Mulai berbelanja dan rasakan kerenyahan kerupuk kami!</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-6 py-3 rounded-full transition-all active:scale-95 shadow-sm shadow-emerald-500/20">
                <i class="bi bi-shop"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection