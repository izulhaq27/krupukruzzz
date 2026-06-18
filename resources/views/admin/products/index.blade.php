@extends('admin.layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Flash Messages -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i class="bi bi-check-circle-fill text-emerald-500 text-xl"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-emerald-600 hover:text-emerald-800"><i class="bi bi-x-lg"></i></button>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i class="bi bi-exclamation-triangle-fill text-red-500 text-xl"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
        <button @click="show = false" class="text-red-600 hover:text-red-800"><i class="bi bi-x-lg"></i></button>
    </div>
    @endif

    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center"><a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900">Admin</a></li>
                    <li><span class="mx-2 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800" aria-current="page">Manajemen Produk</li>
                </ol>
            </nav>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Produk</h2>
                <span class="bg-[#5C5DCD]/10 text-[#5C5DCD] text-xs font-bold px-2.5 py-1 rounded-full">Total {{ $products->total() }}</span>
            </div>
        </div>
        
        <div>
            <a href="{{ route('admin.products.create') }}" class="bg-[#1D2438] hover:bg-[#171C2B] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm flex items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                Tambah Produk
            </a>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <button class="bg-[#1D2438] text-white px-3 py-1.5 rounded-lg text-sm font-medium">Semua</button>
                <button class="text-slate-500 hover:bg-slate-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">Tersedia</button>
                <button class="text-slate-500 hover:bg-slate-50 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">Habis</button>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Cari produk..." class="pl-9 pr-4 py-2 border-slate-200 rounded-xl text-sm focus:ring-[#5C5DCD] focus:border-[#5C5DCD] w-full sm:w-64">
                </div>
                <button class="bg-white border border-slate-200 text-slate-700 p-2 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">
                    <i class="bi bi-filter"></i>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">NO</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- NO -->
                        <td class="py-4 px-6 text-sm font-medium text-slate-500">
                            {{ $loop->iteration + $products->firstItem() - 1 }}
                        </td>
                        
                        <!-- Nama & Gambar -->
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200 flex items-center justify-center">
                                    @if($p->image)
                                        <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="bi bi-image text-slate-400 text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">{{ $p->name }}</div>
                                    <div class="text-xs text-slate-500 truncate max-w-[200px]" title="{{ $p->description }}">
                                        {{ Str::limit($p->description, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Kategori -->
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-1">
                                @forelse($p->categories as $category)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-slate-400 italic">-</span>
                                @endforelse
                            </div>
                        </td>

                        <!-- Harga -->
                        <td class="py-4 px-6">
                            <div class="font-bold text-[#5C5DCD]">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
                        </td>

                        <!-- Stok -->
                        <td class="py-4 px-6">
                            @if($p->stock > 0)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $p->stock }} pcs
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Habis
                                </span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $p->id) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <i class="bi bi-trash-fill text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="w-16 h-16 mx-auto bg-slate-50 rounded-full flex items-center justify-center text-slate-400 mb-4">
                                <i class="bi bi-box-seam text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Belum ada produk</h3>
                            <p class="text-slate-500 mb-4">Mulai dengan menambahkan produk pertama Anda.</p>
                            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 bg-[#1D2438] hover:bg-[#171C2B] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Produk
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        @if($products->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection