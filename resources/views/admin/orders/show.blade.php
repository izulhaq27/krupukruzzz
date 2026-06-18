@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Page Header & Back Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center"><a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900">Admin</a></li>
                    <li><span class="mx-2 text-slate-400">/</span></li>
                    <li><a href="{{ route('admin.orders.index') }}" class="hover:text-slate-900">Pesanan</a></li>
                    <li><span class="mx-2 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800" aria-current="page">#{{ $order->order_number }}</li>
                </ol>
            </nav>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Detail Pesanan #{{ $order->order_number }}</h2>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" class="bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
            <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="bg-[#1D2438] hover:bg-[#171C2B] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-printer"></i>
                Cetak Invoice
            </a>
        </div>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i class="bi bi-check-circle-fill text-emerald-500 text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-emerald-600 hover:text-emerald-800"><i class="bi bi-x-lg"></i></button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Customer & Info -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Customer Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#5C5DCD]/10 text-[#5C5DCD] flex items-center justify-center text-lg">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Informasi Customer</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama</div>
                        <div class="font-medium text-slate-900">{{ $order->user->name ?? $order->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</div>
                        <div class="font-medium text-slate-900">{{ $order->user->email ?? $order->email }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Telepon</div>
                        <div class="font-medium text-slate-900">{{ $order->phone }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Alamat Pengiriman</div>
                        <div class="font-medium text-slate-900 leading-relaxed">{{ $order->address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}</div>
                    </div>
                </div>
            </div>

            <!-- Order Status Update Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Update Status</h3>
                </div>
                <div class="p-5">
                    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <select name="status" class="w-full border-slate-200 rounded-xl text-sm focus:ring-[#5C5DCD] focus:border-[#5C5DCD]">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Diproses (Sudah Bayar)</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-[#1D2438] hover:bg-[#171C2B] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm">
                            Simpan Status
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right Column: Order Details & Tracking -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Order Details -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Ringkasan Pembayaran</h3>
                    </div>
                    
                    @php
                        $statusClasses = match($order->status) {
                            'pending' => 'bg-amber-100 text-amber-700',
                            'processed' => 'bg-blue-100 text-blue-700',
                            'shipped' => 'bg-emerald-100 text-emerald-700',
                            'completed', 'paid' => 'bg-emerald-100 text-emerald-700',
                            'cancelled', 'failed' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusClasses }}">
                        {{ $order->status_label ?? ucfirst($order->status) }}
                    </span>
                </div>
                
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/30 border-b border-slate-100">
                                    <th class="py-3 px-5 text-xs font-semibold text-slate-500 uppercase">Produk</th>
                                    <th class="py-3 px-5 text-xs font-semibold text-slate-500 uppercase text-center">Qty</th>
                                    <th class="py-3 px-5 text-xs font-semibold text-slate-500 uppercase text-right">Harga</th>
                                    <th class="py-3 px-5 text-xs font-semibold text-slate-500 uppercase text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($order->items as $item)
                                <tr class="hover:bg-slate-50/30">
                                    <td class="py-4 px-5">
                                        <div class="font-bold text-slate-900">{{ $item->product_name }}</div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            @if($item->product && $item->product->categories->isNotEmpty())
                                                {{ $item->product->categories->pluck('name')->join(', ') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-5 text-center font-medium text-slate-700">{{ $item->quantity }}</td>
                                    <td class="py-4 px-5 text-right text-slate-700">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-4 px-5 text-right font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-50/50">
                                <tr>
                                    <td colspan="3" class="py-4 px-5 text-right font-semibold text-slate-500 uppercase text-xs tracking-wider">Total Pembayaran</td>
                                    <td class="py-4 px-5 text-right font-bold text-[#5C5DCD] text-xl">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Proof (if any) -->
            @if($order->payment_proof)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        <i class="bi bi-image"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Bukti Transfer</h3>
                </div>
                <div class="p-5 flex flex-col sm:flex-row gap-6 items-start">
                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="block shrink-0 relative group">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-32 h-auto rounded-xl border border-slate-200 shadow-sm group-hover:opacity-90 transition-opacity">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="bg-slate-900/50 text-white p-2 rounded-full backdrop-blur-sm"><i class="bi bi-arrows-fullscreen"></i></div>
                        </div>
                    </a>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Bank Pengirim</div>
                        <div class="font-medium text-slate-900 mb-4">{{ $order->bank_name ?? '-' }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tanggal Pesanan</div>
                        <div class="font-medium text-slate-900">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tracking Resi Form -->
            <div id="resi-form" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Pengiriman & Resi</h3>
                </div>
                <div class="p-5">
                    <form action="{{ route('admin.orders.update-tracking', $order->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Resi *</label>
                                <input type="text" class="w-full border-slate-200 rounded-xl text-sm focus:ring-[#5C5DCD] focus:border-[#5C5DCD]" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Kurir *</label>
                                <select class="w-full border-slate-200 rounded-xl text-sm focus:ring-[#5C5DCD] focus:border-[#5C5DCD]" name="shipping_courier" required>
                                    <option value="">Pilih Kurir</option>
                                    <option value="jne" {{ $order->shipping_courier == 'jne' ? 'selected' : '' }}>JNE</option>
                                    <option value="tiki" {{ $order->shipping_courier == 'tiki' ? 'selected' : '' }}>TIKI</option>
                                    <option value="pos" {{ $order->shipping_courier == 'pos' ? 'selected' : '' }}>POS Indonesia</option>
                                    <option value="sicepat" {{ $order->shipping_courier == 'sicepat' ? 'selected' : '' }}>SiCepat</option>
                                    <option value="jnt" {{ $order->shipping_courier == 'jnt' ? 'selected' : '' }}>J&T</option>
                                    <option value="anteraja" {{ $order->shipping_courier == 'anteraja' ? 'selected' : '' }}>AnterAja</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Layanan (Opsional)</label>
                                <input type="text" class="w-full border-slate-200 rounded-xl text-sm focus:ring-[#5C5DCD] focus:border-[#5C5DCD]" name="shipping_service" value="{{ old('shipping_service', $order->shipping_service) }}" placeholder="REG, YES, dll">
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-[#5C5DCD] hover:bg-[#4B4CB5] text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                            @if($order->tracking_number)
                                <i class="bi bi-pencil"></i> Update Resi
                            @else
                                <i class="bi bi-check-lg"></i> Simpan Resi
                            @endif
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection