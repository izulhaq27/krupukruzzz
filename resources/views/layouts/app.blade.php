<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KrupuKruzzz') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    
    <!-- Bootstrap Icons (still useful for icons) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js for interactions (dropdowns, alerts) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Preloader */
        #preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: white; z-index: 9999;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            transition: opacity 0.4s ease, visibility 0.4s;
        }
        .preloader-hidden { opacity: 0; visibility: hidden; }
        .loader-logo { width: 72px; animation: pulse 1.5s infinite; margin-bottom: 20px; }
        .loader-bar { width: 120px; height: 4px; background: #E5E7EB; border-radius: 999px; position: relative; overflow: hidden; }
        .loader-bar::after {
            content: ''; position: absolute; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, #10B981, #34D399);
            animation: loading 1.2s infinite;
        }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.7; } 50% { transform: scale(1.08); opacity: 1; } }
        @keyframes loading { 0% { left: -100%; } 100% { left: 100%; } }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">
    
    <div id="preloader">
        <img src="{{ asset('images/logo.png') }}" class="loader-logo" alt="Loading...">
        <div class="loader-bar"></div>
        <p class="mt-4 text-sm font-medium text-slate-400">Menyiapkan kelezatan...</p>
    </div>

    <div id="app" class="flex-grow flex flex-col pb-20 lg:pb-0">
        
        {{-- NAVBAR — Desktop --}}
        <nav x-data="{ scrolled: false }" 
             @scroll.window="scrolled = (window.pageYOffset > 10)"
             :class="scrolled ? 'shadow-md shadow-slate-200/50' : 'border-b border-slate-100'"
             class="hidden lg:block sticky top-0 z-50 bg-white/80 backdrop-blur-xl transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-emerald-500 font-extrabold text-xl tracking-tight hover:text-emerald-600 transition">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9">
                    KrupuKruzzz
                </a>
                
                <!-- Links -->
                <div class="flex items-center gap-1">
                    <a href="{{ route('products.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition {{ Request::routeIs('products.*') && !Request::routeIs('products.show') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:text-emerald-500 hover:bg-slate-50' }}">
                        <i class="bi bi-shop text-lg"></i> Produk
                    </a>
                    
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition {{ Request::routeIs('categories.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:text-emerald-500 hover:bg-slate-50' }}">
                        <i class="bi bi-tags text-lg"></i> Kategori
                    </a>
                    
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition {{ Request::routeIs('cart.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:text-emerald-500 hover:bg-slate-50' }}">
                        <i class="bi bi-cart3 text-lg"></i> Keranjang
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="bg-amber-500 text-amber-950 text-xs font-bold px-2 py-0.5 rounded-full">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    
                    @auth
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition {{ Request::routeIs('orders.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:text-emerald-500 hover:bg-slate-50' }}">
                        <i class="bi bi-box-seam text-lg"></i> Pesanan Saya
                        @php
                            $pendingCount = auth()->user()->pendingOrders()->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="bg-amber-500 text-amber-950 text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    @endauth
                    
                    <a href="{{ route('tracking.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg font-medium transition {{ Request::routeIs('tracking.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:text-emerald-500 hover:bg-slate-50' }}">
                        <i class="bi bi-truck text-lg"></i> Lacak Resi
                    </a>
                </div>

                <!-- Auth -->
                <div class="flex items-center border-l border-slate-200 pl-4 ml-2">
                    @guest
                        <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:text-emerald-500 font-medium transition">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    @else
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 px-4 py-2 rounded-lg font-medium text-slate-700 hover:bg-slate-100 transition focus:outline-none">
                                <i class="bi bi-person-circle text-lg text-emerald-500"></i>
                                {{ Auth::user()->name }}
                                <i class="bi bi-chevron-down text-xs ml-1 text-slate-400" :class="{'rotate-180': open}"></i>
                            </button>
                            
                            <!-- Dropdown -->
                            <div x-show="open" x-transition.opacity.duration.200ms x-cloak 
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50">
                                
                                <a href="{{ route('orders.index') }}" class="flex items-center justify-between px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">
                                    <span class="flex items-center gap-2"><i class="bi bi-box-seam"></i> Pesanan Saya</span>
                                    @if(auth()->user()->pendingOrders()->count() > 0)
                                        <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ auth()->user()->pendingOrders()->count() }}</span>
                                    @endif
                                </a>
                                
                                @if(Route::has('dashboard'))
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition">
                                    <i class="bi bi-speedometer"></i> Dashboard
                                </a>
                                @endif
                                
                                <div class="h-px bg-slate-100 my-1"></div>
                                
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        {{-- ALERTS --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 w-full pt-6 space-y-3">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl flex justify-between items-start shadow-sm">
                    <div class="flex gap-3 text-emerald-800">
                        <i class="bi bi-check-circle-fill text-emerald-500 mt-0.5"></i>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600"><i class="bi bi-x-lg"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl flex justify-between items-start shadow-sm">
                    <div class="flex gap-3 text-red-800">
                        <i class="bi bi-exclamation-triangle-fill text-red-500 mt-0.5"></i>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-600"><i class="bi bi-x-lg"></i></button>
                </div>
            @endif

            @if($errors->any())
                <div x-data="{ show: true }" x-show="show" class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl flex justify-between items-start shadow-sm">
                    <div class="flex gap-3 text-red-800">
                        <i class="bi bi-exclamation-triangle-fill text-red-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold mb-1">Terdapat kesalahan:</p>
                            <ul class="list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-600"><i class="bi bi-x-lg"></i></button>
                </div>
            @endif
        </div>

        {{-- MAIN CONTENT --}}
        <main class="flex-grow py-6">
            @yield('content')
        </main>
        
        {{-- FOOTER — Desktop Only --}}
        <footer class="hidden lg:block bg-slate-900 text-slate-300 mt-auto">
            <div class="max-w-7xl mx-auto px-6 py-12">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">
                    <!-- Brand -->
                    <div class="md:col-span-5">
                        <h5 class="flex items-center gap-3 text-white font-bold text-lg mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 brightness-0 invert opacity-90">
                            KrupuKruzzz
                        </h5>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                            <i class="bi bi-geo-alt mr-1"></i> Dusun Garas RT 001 RW 001 Desa Palembon<br>
                            Kecamatan Kanor, Kabupaten Bojonegoro,<br>
                            Jawa Timur, Indonesia
                        </p>
                    </div>
                    
                    <!-- Links -->
                    <div class="md:col-span-3">
                        <h5 class="text-emerald-400 font-bold mb-4">Navigasi</h5>
                        <ul class="space-y-3 text-sm">
                            <li><a href="{{ route('products.index') }}" class="hover:text-emerald-400 transition flex items-center gap-2"><i class="bi bi-chevron-right text-[10px]"></i> Produk</a></li>
                            <li><a href="{{ route('categories.index') }}" class="hover:text-emerald-400 transition flex items-center gap-2"><i class="bi bi-chevron-right text-[10px]"></i> Kategori</a></li>
                            <li><a href="{{ route('tracking.index') }}" class="hover:text-emerald-400 transition flex items-center gap-2"><i class="bi bi-chevron-right text-[10px]"></i> Lacak Resi</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact -->
                    <div class="md:col-span-4">
                        <h5 class="text-emerald-400 font-bold mb-4">Hubungi Kami</h5>
                        <ul class="space-y-3 text-sm text-slate-400">
                            <li class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-emerald-400"><i class="bi bi-whatsapp"></i></div>
                                0816-1550-0168
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-emerald-400"><i class="bi bi-envelope"></i></div>
                                krupukruzzz@gmail.com
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-slate-800 mt-12 pt-8 text-center text-sm text-slate-500">
                    &copy; {{ date('Y') }} KrupuKruzzz. Kerupuk Berkualitas Harga Terjangkau.
                </div>
            </div>
        </footer>
    </div>

    {{-- BOTTOM NAVIGATION — Mobile --}}
    <div class="lg:hidden fixed bottom-0 left-0 w-full h-[68px] bg-white/90 backdrop-blur-lg border-t border-slate-100 z-50 flex justify-around items-center px-2 pb-safe shadow-[0_-4px_20px_rgba(0,0,0,0.03)]">
        
        {{-- 1. Home --}}
        <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center flex-1 h-full relative text-slate-400 hover:text-emerald-500 transition-colors {{ Request::routeIs('products.index') ? 'text-emerald-500' : '' }}">
            @if(Request::routeIs('products.index'))
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-6 h-1 bg-emerald-500 rounded-b-full"></div>
            @endif
            <i class="bi bi-house{{ Request::routeIs('products.index') ? '-fill -translate-y-0.5' : '' }} text-2xl transition-transform"></i>
            <span class="text-[10px] font-semibold mt-1">Beranda</span>
        </a>
        
        {{-- 2. Kategori --}}
        <a href="{{ route('categories.index') }}" class="flex flex-col items-center justify-center flex-1 h-full relative text-slate-400 hover:text-emerald-500 transition-colors {{ Request::routeIs('categories.*') ? 'text-emerald-500' : '' }}">
            @if(Request::routeIs('categories.*'))
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-6 h-1 bg-emerald-500 rounded-b-full"></div>
            @endif
            <i class="bi bi-grid{{ Request::routeIs('categories.*') ? '-fill -translate-y-0.5' : '' }} text-2xl transition-transform"></i>
            <span class="text-[10px] font-semibold mt-1">Kategori</span>
        </a>
        
        {{-- 3. Cart --}}
        <a href="{{ route('cart.index') }}" class="flex flex-col items-center justify-center flex-1 h-full relative text-slate-400 hover:text-emerald-500 transition-colors {{ Request::routeIs('cart.*') ? 'text-emerald-500' : '' }}">
            @if(Request::routeIs('cart.*'))
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-6 h-1 bg-emerald-500 rounded-b-full"></div>
            @endif
            <div class="relative">
                <i class="bi bi-bag{{ Request::routeIs('cart.*') ? '-fill -translate-y-0.5' : '' }} text-2xl transition-transform block"></i>
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-1 -right-2 bg-amber-500 text-amber-950 text-[9px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white shadow-sm">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </div>
            <span class="text-[10px] font-semibold mt-1">Keranjang</span>
        </a>
        
        {{-- 4. Tracking --}}
        <a href="{{ route('tracking.index') }}" class="flex flex-col items-center justify-center flex-1 h-full relative text-slate-400 hover:text-emerald-500 transition-colors {{ Request::routeIs('tracking.*') ? 'text-emerald-500' : '' }}">
            @if(Request::routeIs('tracking.*'))
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-6 h-1 bg-emerald-500 rounded-b-full"></div>
            @endif
            <i class="bi bi-truck{{ Request::routeIs('tracking.*') ? '-front-fill -translate-y-0.5' : '' }} text-2xl transition-transform"></i>
            <span class="text-[10px] font-semibold mt-1">Lacak</span>
        </a>
        
        {{-- 5. Profile --}}
        @auth
            <a href="{{ Route::has('profile.edit') ? route('profile.edit') : route('orders.index') }}" class="flex flex-col items-center justify-center flex-1 h-full relative text-slate-400 hover:text-emerald-500 transition-colors {{ Request::routeIs('profile.*') || Request::routeIs('orders.*') ? 'text-emerald-500' : '' }}">
                @if(Request::routeIs('profile.*') || Request::routeIs('orders.*'))
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-6 h-1 bg-emerald-500 rounded-b-full"></div>
                @endif
                <i class="bi bi-person{{ Request::routeIs('profile.*') || Request::routeIs('orders.*') ? '-fill -translate-y-0.5' : '' }} text-2xl transition-transform"></i>
                <span class="text-[10px] font-semibold mt-1">Profil</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center flex-1 h-full relative text-slate-400 hover:text-emerald-500 transition-colors {{ Request::routeIs('login') ? 'text-emerald-500' : '' }}">
                @if(Request::routeIs('login'))
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-6 h-1 bg-emerald-500 rounded-b-full"></div>
                @endif
                <i class="bi bi-person{{ Request::routeIs('login') ? '-fill -translate-y-0.5' : '' }} text-2xl transition-transform"></i>
                <span class="text-[10px] font-semibold mt-1">Masuk</span>
            </a>
        @endauth
    </div>
    
    <script>
        // Preloader Logic
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                setTimeout(() => {
                    preloader.classList.add('preloader-hidden');
                    setTimeout(() => preloader.remove(), 400);
                }, 300);
            }
        });

        // Global Form Submission Loading State
        document.addEventListener('submit', function(e) {
            const btn = e.target.querySelector('button[type="submit"]');
            if (btn && !btn.hasAttribute('data-no-loader')) {
                btn.classList.add('opacity-75', 'cursor-not-allowed');
                const originalHtml = btn.innerHTML;
                if(!btn.innerHTML.includes('spinner-border')) {
                    // Simple tailwind spinner
                    btn.innerHTML += `<svg class="animate-spin ml-2 h-4 w-4 text-current inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
                }
                setTimeout(() => { btn.disabled = true; }, 50);
            }
        });
    </script>
</body>
</html>