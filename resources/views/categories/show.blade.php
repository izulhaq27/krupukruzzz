@extends('layouts.app')

@section('content')
<!-- Category Hero Banner -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
    <div class="rounded-3xl p-6 md:p-10 text-white relative overflow-hidden flex items-center min-h-[200px] animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]"
         style="background: linear-gradient(135deg, #10B981 0%, #064E3B 100%);">
        
        <!-- Decoration -->
        <div class="absolute -top-5 right-[10%] w-36 h-36 border-2 border-dashed border-white/10 rounded-full"></div>
        <div class="absolute -bottom-10 -right-5 w-28 h-28 bg-white/5 rounded-full"></div>
        <div class="hidden md:block absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="relative z-10 w-full">
            <nav class="flex items-center space-x-2 text-sm text-white/70 mb-4">
                <a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Beranda</a>
                <i class="bi bi-chevron-right text-[10px] text-white/50"></i>
                <a href="{{ route('categories.index') }}" class="hover:text-white transition-colors">Kategori</a>
                <i class="bi bi-chevron-right text-[10px] text-white/50"></i>
                <span class="text-white font-bold">{{ $category->name }}</span>
            </nav>
            <div class="flex items-center gap-4 mb-3">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-16 h-16 rounded-full object-cover border-4 border-white/30 shadow-lg shrink-0">
                @else
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center shrink-0 border-4 border-white/30">
                        <i class="bi bi-tag-fill text-white text-2xl"></i>
                    </div>
                @endif
                <div>
                    <h1 class="font-extrabold text-2xl md:text-4xl leading-tight tracking-tight mb-1">{{ $category->name }}</h1>
                    <span class="inline-flex items-center bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full border border-white/20">
                        {{ $category->products->count() }} Produk
                    </span>
                </div>
            </div>
            @if($category->description)
                <p class="text-white/80 max-w-xl text-sm leading-relaxed">{{ $category->description }}</p>
            @endif
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <!-- Filter Bar -->
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-200">
        <h5 class="font-bold text-xl text-slate-800">Koleksi Produk</h5>
    </div>

    <!-- Product Grid -->
    @if($category->products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 lg:gap-6">
            @foreach($category->products as $product)
            <div class="animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards] opacity-0" style="animation-delay: {{ $loop->iteration * 0.06 }}s;">
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden flex flex-col h-full transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-100 group">
                    <!-- Image -->
                    <div class="relative aspect-square bg-slate-50 overflow-hidden">
                        <a href="{{ route('products.show', $product->slug) }}" class="block h-full">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="w-full h-full flex justify-center items-center text-slate-300">
                                    <i class="bi bi-image text-4xl"></i>
                                </div>
                            @endif
                        </a>
                    </div>

                    <!-- Card Body -->
                    <div class="p-3 sm:p-4 flex flex-col flex-grow">
                        <a href="{{ route('products.show', $product->slug) }}" class="mb-1 block">
                            <h6 class="font-bold text-sm text-slate-800 tracking-tight line-clamp-2 leading-snug group-hover:text-emerald-600 transition-colors">{{ $product->name }}</h6>
                        </a>
                        <div class="mb-3">
                            <span class="font-bold text-emerald-500 text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-auto flex gap-2 items-center">
                            <a href="{{ route('products.show', $product->slug) }}"
                               class="flex items-center justify-center w-9 h-9 shrink-0 bg-slate-100 text-slate-500 rounded-lg hover:bg-slate-200 transition-colors">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="grow">
                                    @csrf
                                    <input type="hidden" name="redirect_to" value="cart">
                                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center gap-1.5 h-9 rounded-lg font-bold text-xs transition-colors active:scale-95">
                                        <i class="bi bi-bag-plus hidden sm:inline text-sm"></i>
                                        <span>Beli</span>
                                    </button>
                                </form>
                            @else
                                <button disabled class="grow bg-slate-200 text-slate-500 h-9 rounded-lg text-xs font-semibold cursor-not-allowed">Habis</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <div class="text-slate-200 mb-6"><i class="bi bi-box-seam text-7xl"></i></div>
            <h4 class="font-bold text-2xl text-slate-800 mb-3">Belum Ada Produk</h4>
            <p class="text-slate-500 max-w-sm mx-auto mb-8">Tidak ada produk dalam kategori ini saat ini.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-white border-2 border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-bold px-6 py-3 rounded-full transition-all active:scale-95">
                Lihat Kategori Lain
            </a>
        </div>
    @endif

    <!-- Related Categories -->
    @if($relatedCategories->count() > 0)
    <div class="mt-16 pt-8 border-t border-slate-200 animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
        <h5 class="font-bold text-xl text-slate-800 mb-6">Kategori Lainnya</h5>
        <div class="flex gap-4 overflow-x-auto pb-3 scrollbar-hide">
            @foreach($relatedCategories as $related)
            <a href="{{ route('categories.show', $related->slug) }}" class="shrink-0 text-decoration-none" style="width: 140px;">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 text-center hover:-translate-y-1 hover:shadow-md hover:border-emerald-100 transition-all duration-200">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-tag-fill text-xl"></i>
                    </div>
                    <h6 class="font-bold text-sm text-slate-800 truncate mb-1">{{ $related->name }}</h6>
                    <small class="text-slate-400 text-xs">{{ $related->products_count }} Produk</small>
                </div>
            </a>
            @endforeach
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