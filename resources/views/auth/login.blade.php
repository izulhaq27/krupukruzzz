@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md animate-[fadeInUp_0.5s_cubic-bezier(0.4,0,0.2,1)_forwards]">
        
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-4 drop-shadow-md">
            <h2 class="font-extrabold text-3xl text-slate-900 tracking-tight">Selamat Datang</h2>
            <p class="text-slate-500 mt-2">Masuk ke akun KrupuKruzzz Anda</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-[0_10px_40px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="p-8 sm:p-10">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-envelope text-slate-400"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@email.com" 
                                   class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors @error('email') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 transition-colors">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative" x-data="{ showPassword: false }">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="bi bi-lock text-slate-400"></i>
                            </div>
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••" 
                                   class="block w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-colors @error('password') border-red-500 focus:ring-red-500/10 focus:border-red-500 @enderror">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none">
                                <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8 flex items-center">
                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 text-emerald-500 border-slate-300 rounded focus:ring-emerald-500 focus:ring-offset-0">
                        <label for="remember" class="ml-2 block text-sm text-slate-600">
                            Ingat Saya
                        </label>
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-4 rounded-full shadow-sm shadow-emerald-500/20 transition-all duration-200 active:scale-95">
                            Masuk <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-sm text-slate-500">Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-700 transition-colors">Daftar Sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection