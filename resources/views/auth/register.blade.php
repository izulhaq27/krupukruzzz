@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-2xl animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
        
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4 drop-shadow-md">
            <h2 class="font-extrabold text-3xl text-slate-900 tracking-tight">Daftar Akun Baru</h2>
            <p class="text-slate-500 mt-2">Bergabunglah dan nikmati kerupuk kualitas premium</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="p-8 sm:p-10">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-person text-slate-400"></i>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap" 
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors @error('name') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror">
                        </div>
                        @error('name')
                            <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-envelope text-slate-400"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com" 
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors @error('email') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon/WA</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-phone text-slate-400"></i>
                            </div>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="08xxxxxxxxx" 
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors @error('phone') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror">
                        </div>
                        @error('phone')
                            <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div x-data="{ show: false }">
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-lock text-slate-400"></i>
                                </div>
                                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="••••••••" 
                                       class="block w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors @error('password') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                                    <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div x-data="{ show: false }">
                            <label for="password-confirm" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-lock-fill text-slate-400"></i>
                                </div>
                                <input id="password-confirm" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" 
                                       class="block w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                                    <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8 flex items-start">
                        <div class="flex items-center h-5 mt-0.5">
                            <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-emerald-500 border-slate-300 rounded focus:ring-emerald-500 focus:ring-offset-0">
                        </div>
                        <label for="terms" class="ml-2 block text-sm text-slate-600">
                            Saya setuju dengan <a href="#" class="text-emerald-600 hover:text-emerald-700 transition-colors">Syarat & Ketentuan</a> serta <a href="#" class="text-emerald-600 hover:text-emerald-700 transition-colors">Kebijakan Privasi</a> KrupuKruzzz
                        </label>
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="w-full flex justify-center items-center bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all duration-200 active:scale-95">
                            Daftar Akun
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-sm text-slate-500">Sudah punya akun? 
                            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-700 transition-colors">Masuk di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection