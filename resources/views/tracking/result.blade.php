@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('tracking.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-200 text-slate-600 hover:bg-slate-50 rounded-full transition-all shadow-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 tracking-tight">Hasil Pencarian Resi</h2>
    </div>

    @if(isset($order) && $order)
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
        <!-- Tracking Timeline -->
        <div class="lg:w-5/12">
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm h-full">
                <h5 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
                    <i class="bi bi-geo-alt text-emerald-500"></i> Status Pengiriman
                </h5>
                @php
                    $steps = [
                        'pending'   => ['label' => 'Pesanan Dibuat',       'desc' => 'Menunggu pembayaran'],
                        'paid'      => ['label' => 'Pembayaran Diterima',  'desc' => 'Sedang diproses penjual'],
                        'processed' => ['label' => 'Pesanan Diproses',     'desc' => 'Dikemas dan disiapkan'],
                        'shipped'   => ['label' => 'Sedang Dikirim',       'desc' => 'Dalam perjalanan ke alamat Anda'],
                        'completed' => ['label' => 'Pesanan Selesai',      'desc' => 'Paket telah diterima'],
                    ];
                    $currentStatus = $order->status;
                    $statusIndex = array_keys($steps);
                @endphp
                
                <div class="relative ml-3 pl-6 border-l-2 border-slate-200 space-y-6 mt-4">
                    @foreach($steps as $key => $step)
                        @php
                            $isActive = in_array($key, array_slice($statusIndex, 0, array_search($currentStatus, $statusIndex) + 1));
                            $isCurrent = $key == $currentStatus;
                            if(in_array($currentStatus, ['cancelled', 'failed']) && $key != 'pending') {
                                $isActive = false; $isCurrent = false;
                            }
                        @endphp
                        <div class="relative">
                            <div class="absolute -left-[33px] top-0 w-6 h-6 rounded-full flex items-center justify-center border-2 transition-all
                                {{ $isCurrent ? 'bg-emerald-500 border-emerald-500 shadow-[0_0_0_4px_rgba(16,185,129,0.15)]' : ($isActive ? 'bg-emerald-500 border-emerald-500' : 'bg-white border-slate-300') }}">
                                @if($isCurrent)
                                    <div class="w-2 h-2 rounded-full bg-white animate-ping"></div>
                                @elseif($isActive)
                                    <i class="bi bi-check-lg text-white text-[10px]"></i>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                                @endif
                            </div>
                            <h6 class="font-bold mb-1 {{ $isCurrent ? 'text-emerald-600' : ($isActive ? 'text-slate-700' : 'text-slate-400') }}">{{ $step['label'] }}</h6>
                            <p class="text-sm text-slate-400 m-0">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                    
                    @if(in_array($currentStatus, ['cancelled', 'failed']))
                        <div class="relative">
                            <div class="absolute -left-[33px] top-0 w-6 h-6 rounded-full flex items-center justify-center bg-red-500 border-2 border-red-500 shadow-[0_0_0_4px_rgba(239,68,68,0.15)]">
                                <i class="bi bi-x-lg text-white text-[10px]"></i>
                            </div>
                            <h6 class="font-bold mb-1 text-red-600">Dibatalkan</h6>
                            <p class="text-sm text-slate-400 m-0">Pesanan dibatalkan / gagal</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Pesanan & Pengiriman -->
        <div class="lg:w-7/12 space-y-6">
            <!-- Info Ekspedisi -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <div class="flex justify-between items-start mb-6">
                    <h5 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                        <i class="bi bi-truck text-emerald-500"></i> Info Ekspedisi
                    </h5>
                    @if($order->tracking_link)
                        <a href="{{ $order->tracking_link }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold px-4 py-2 rounded-full transition-all active:scale-95">
                            Cek Web <i class="bi bi-box-arrow-up-right text-xs"></i>
                        </a>
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <small class="text-slate-400 text-xs font-medium block mb-2">Kurir</small>
                        <span class="font-bold text-lg text-slate-800 uppercase">{{ $order->shipping_courier ?? '-' }}</span>
                        <span class="text-xs font-medium bg-white border border-slate-200 text-slate-600 px-2 py-1 rounded-full ml-2">{{ $order->shipping_service ?? 'REG' }}</span>
                    </div>
                    <div class="bg-emerald-50 rounded-2xl p-4 border border-dashed border-emerald-200">
                        <small class="text-emerald-600 text-xs font-medium block mb-2">No. Resi</small>
                        <span class="font-bold text-lg text-emerald-600 font-mono tracking-wider">{{ $order->tracking_number ?? 'Belum tersedia' }}</span>
                    </div>
                    <div class="bg-white rounded-2xl p-4 border border-slate-100">
                        <small class="text-slate-400 text-xs font-medium block mb-2">Dikirim Pada</small>
                        <span class="font-semibold text-slate-800">{{ $order->shipped_at ? $order->shipped_at->format('d M Y, H:i') : '-' }}</span>
                    </div>
                    <div class="bg-white rounded-2xl p-4 border border-slate-100">
                        <small class="text-slate-400 text-xs font-medium block mb-2">Estimasi Tiba</small>
                        <span class="font-semibold text-slate-800">{{ $order->estimated_delivery ? $order->estimated_delivery->format('d M Y') : '3-5 hari kerja' }}</span>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                <h5 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
                    <i class="bi bi-receipt text-emerald-500"></i> Ringkasan Pesanan
                </h5>
                <div class="flex justify-between pb-4 mb-4 border-b border-slate-100">
                    <div>
                        <small class="text-slate-400 text-xs font-medium block mb-1">No. Pesanan</small>
                        <span class="font-semibold text-slate-800">{{ $order->order_number }}</span>
                    </div>
                    <div class="text-right">
                        <small class="text-slate-400 text-xs font-medium block mb-1">Tanggal</small>
                        <span class="font-semibold text-slate-800">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <small class="text-slate-400 text-xs font-medium block mb-1">Total Tagihan</small>
                        <span class="font-extrabold text-2xl text-emerald-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    @php
                        $badge = match($order->status) {
                            'pending'   => 'bg-amber-100 text-amber-800',
                            'completed' => 'bg-emerald-100 text-emerald-800',
                            'cancelled', 'failed' => 'bg-red-100 text-red-800',
                            default     => 'bg-blue-100 text-blue-800',
                        };
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold {{ $badge }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="flex justify-center">
        <div class="w-full max-w-lg text-center bg-white rounded-3xl border border-slate-100 shadow-sm p-12 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="bi bi-search text-red-400 text-4xl"></i>
            </div>
            <h3 class="font-bold text-2xl text-slate-900 mb-3">Resi Tidak Ditemukan</h3>
            <p class="text-slate-500 max-w-sm mx-auto mb-8 leading-relaxed">
                Nomor resi atau email yang Anda masukkan tidak sesuai dengan database kami. Silakan periksa kembali.
            </p>
            <a href="{{ route('tracking.index') }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-6 py-3 rounded-full shadow-sm shadow-emerald-500/20 transition-all active:scale-95">
                Coba Lagi
            </a>
        </div>
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