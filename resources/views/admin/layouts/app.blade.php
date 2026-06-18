<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - KrupuKruzz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Vite (Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: window.innerWidth >= 1024 }" @resize.window="sidebarOpen = window.innerWidth >= 1024">

    <!-- Overlay for Mobile -->
    <div x-show="sidebarOpen" x-transition.opacity 
         class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden"
         @click="sidebarOpen = false" x-cloak></div>

    <!-- SIDEBAR -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="hidden lg:flex fixed inset-y-0 left-0 z-30 w-64 bg-[#1D2438] text-slate-300 transition-transform duration-300 ease-in-out flex-col">
        
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between h-16 px-6 bg-[#171C2B]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded bg-emerald-500 flex items-center justify-center text-white font-bold text-xl">K</div>
                <span class="text-white font-bold text-lg tracking-wide">KrupuKruzzz</span>
            </a>
            <!-- Mobile Close Button -->
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
            <div class="px-2 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Menu</div>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#5C5DCD] text-white font-medium shadow-sm' : 'hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-grid-fill text-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                Ringkasan
            </a>
            
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors mt-1 {{ request()->routeIs('admin.orders.*') ? 'bg-[#5C5DCD] text-white font-medium shadow-sm' : 'hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-bag-check-fill text-lg {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Kelola Pesanan
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors mt-1 {{ request()->routeIs('admin.products.*') ? 'bg-[#5C5DCD] text-white font-medium shadow-sm' : 'hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-box-seam-fill text-lg {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Manajemen Produk
            </a>

            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors mt-1 {{ request()->routeIs('admin.categories.*') ? 'bg-[#5C5DCD] text-white font-medium shadow-sm' : 'hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-tags-fill text-lg {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Kategori
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors mt-1 {{ request()->routeIs('admin.users.*') ? 'bg-[#5C5DCD] text-white font-medium shadow-sm' : 'hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-people-fill text-lg {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Kelola Pengguna
            </a>
        </nav>

        <!-- Sidebar Footer (Logout) -->
        <div class="p-4 border-t border-white/10">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2 text-sm font-medium text-slate-300 bg-white/5 rounded-lg hover:bg-white/10 hover:text-white transition-colors">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'" class="min-h-screen transition-all duration-300 ease-in-out flex flex-col">
        
        <!-- TOPBAR -->
        <header class="sticky top-0 z-10 flex items-center justify-between h-16 px-4 bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm sm:px-6">
            <div class="flex items-center gap-4">
                <!-- Hamburger Toggle -->
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block p-2 -ml-2 text-slate-500 rounded-lg hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                
                <!-- Page Title Placeholder (Optional) -->
                <h1 class="hidden text-lg font-bold text-slate-800 sm:block">
                    @yield('title', 'Admin Panel')
                </h1>
            </div>

            <!-- Right Topbar -->
            <div class="flex items-center gap-4">
                <!-- Notifications (Dummy) -->
                <button class="relative p-2 text-slate-500 hover:text-slate-700 transition-colors">
                    <i class="bi bi-bell text-xl"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <div class="h-8 w-px bg-slate-200 mx-1"></div>

                <!-- Profile -->
                <div class="flex items-center gap-3">
                    <div class="hidden text-right sm:block">
                        <div class="text-sm font-bold text-slate-800 leading-none mb-1">Admin</div>
                        <div class="text-xs text-slate-500 leading-none">Administrator</div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500">
                        <i class="bi bi-person-fill text-xl"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN PAGE CONTENT -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 pb-20 lg:pb-8">
            @yield('content')
        </main>
        
    </div>

    <!-- MOBILE BOTTOM NAVIGATION (FOOTBAR) -->
    <nav class="lg:hidden fixed bottom-0 w-full bg-white border-t border-slate-200 z-40 pb-safe">
        <div class="flex justify-around items-center h-14">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full space-y-0.5 {{ request()->routeIs('admin.dashboard') ? 'text-[#5C5DCD]' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="bi bi-grid-fill text-lg"></i>
                <span class="text-[9px] font-semibold">Ringkasan</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-0.5 {{ request()->routeIs('admin.orders.*') ? 'text-[#5C5DCD]' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="bi bi-cart-fill text-lg"></i>
                <span class="text-[9px] font-semibold">Pesanan</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-0.5 {{ request()->routeIs('admin.products.*') ? 'text-[#5C5DCD]' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="bi bi-box-seam-fill text-lg"></i>
                <span class="text-[9px] font-semibold">Produk</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex flex-col items-center justify-center w-full h-full space-y-0.5 {{ request()->routeIs('admin.categories.*') ? 'text-[#5C5DCD]' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="bi bi-tags-fill text-lg"></i>
                <span class="text-[9px] font-semibold">Kategori</span>
            </a>
        </div>
    </nav>

</body>
</html>