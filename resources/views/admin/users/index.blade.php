@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <nav class="flex text-sm text-slate-500 mb-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center"><a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900">Admin</a></li>
                    <li><span class="mx-2 text-slate-400">/</span></li>
                    <li class="font-medium text-slate-800" aria-current="page">Pengguna</li>
                </ol>
            </nav>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Pengguna</h2>
                <span class="bg-[#5C5DCD]/10 text-[#5C5DCD] text-xs font-bold px-2.5 py-1 rounded-full">Total {{ $users->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-slate-900">Semua Pengguna</h3>
            <div class="relative w-full sm:w-64">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari pengguna..." class="pl-9 pr-4 py-2 border-slate-200 rounded-xl text-sm focus:ring-[#5C5DCD] focus:border-[#5C5DCD] w-full">
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">ID</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Profil</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kontak</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Alamat & Lokasi</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <!-- ID -->
                        <td class="py-4 px-6 text-sm font-medium text-slate-500">
                            #{{ $user->id }}
                        </td>
                        
                        <!-- Profil -->
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0 {{ $user->is_admin ? 'bg-emerald-500' : 'bg-[#5C5DCD]' }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Kontak -->
                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                <a href="mailto:{{ $user->email }}" class="flex items-center gap-2 text-sm text-[#5C5DCD] hover:underline">
                                    <i class="bi bi-envelope"></i> {{ $user->email }}
                                </a>
                                @if($user->phone)
                                <a href="tel:{{ $user->phone }}" class="flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
                                    <i class="bi bi-telephone"></i> {{ $user->phone }}
                                </a>
                                @endif
                            </div>
                        </td>

                        <!-- Alamat -->
                        <td class="py-4 px-6">
                            @if($user->address)
                                <div class="text-sm text-slate-700 mb-1 max-w-[250px] truncate" title="{{ $user->address }}">{{ $user->address }}</div>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    @if($user->city)<span>{{ $user->city }}</span>@endif
                                    @if($user->province)<span class="w-1 h-1 rounded-full bg-slate-300"></span><span>{{ $user->province }}</span>@endif
                                    @if($user->postal_code)<span class="w-1 h-1 rounded-full bg-slate-300"></span><span class="font-mono">{{ $user->postal_code }}</span>@endif
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic">Belum diisi</span>
                            @endif
                        </td>

                        <!-- Role -->
                        <td class="py-4 px-6">
                            @if($user->is_admin)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    User
                                </span>
                            @endif
                        </td>

                        <!-- Terdaftar -->
                        <td class="py-4 px-6">
                            <div class="text-sm font-medium text-slate-900">{{ $user->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-slate-500">{{ $user->created_at->format('H:i') }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="w-16 h-16 mx-auto bg-slate-50 rounded-full flex items-center justify-center text-slate-400 mb-4">
                                <i class="bi bi-people text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-1">Belum ada pengguna</h3>
                            <p class="text-slate-500">Tidak ada user terdaftar di sistem.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection