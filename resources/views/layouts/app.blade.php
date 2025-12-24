<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KrupuKruzzz') }}</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #388e3c;  /* Forest Green - Muted/Dimmer */
            --primary-green-dark: #1b5e20;
            --light-bg: #f5f7f6;
            --text-dark: #2c3e50;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
        }
        
        /*Navbar*/
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-green) !important;
            letter-spacing: -0.5px;
        }
        
        .navbar-nav .nav-link {
            color: #555 !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.2s;
        }
        
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
            color: var(--primary-green) !important;
            background: rgba(56, 142, 60, 0.05);
            border-radius: 6px;
        }
        
        .cart-badge {
            background: #ffc107 !important;
            color: #333;
            font-weight: 600;
        }
        
        /*Button*/
        .btn-success {
            background: var(--primary-green);
            border-color: var(--primary-green);
            font-weight: 600;
        }
        
        .btn-success:hover {
            background: var(--primary-green-dark);
            border-color: var(--primary-green-dark);
        }
        
        /*Product Card*/
        .product-card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.15);
        }
        
        .product-card .price {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.3rem;
        }
        
        /*Footer*/
        footer {
            background: #1a1d20;
            color: white;
            padding: 2rem 0;
            margin-top: auto;
            width: 100%;
        }
        
        .footer-alamat {
            color: #b0b7c3;
            font-size: 0.9rem;
        }
        
        /*Footer Bootom*/
        html, body {
            height: 100%;
        }
        
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        footer {
            flex-shrink: 0;
        }
        
        /*New Style*/
        .orders-badge {
            background: #ffc107 !important;
            color: #333;
            font-weight: 600;
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
            margin-left: 3px;
        }
        
        .dropdown-item.active, .dropdown-item:active {
            background-color: var(--primary-green);
        }
    </style>
</head>
<body>
    <div id="app">
        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-lg-5"> <!-- Full Width Navbar -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="KrupuKruzz Logo" 
                         height="35" 
                         class="me-2">
                    KrupuKruzzz
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="bi bi-shop"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">
                        <i class="bi bi-tags"></i> Kategori
                        </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3"></i> Keranjang
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="badge cart-badge">{{ count(session('cart')) }}</span>
                                @endif
                            </a>
                        </li>
                        
                        {{--Orders Show --}}
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="bi bi-box-seam"></i> Pesanan Saya
                                @php
                                    $pendingCount = 0;
                                    if (auth()->check()) {
                                        $pendingCount = auth()->user()->pendingOrders()->count();
                                    }
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="badge orders-badge">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        @endauth
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tracking.index') }}">
                                <i class="bi bi-truck"></i> Lacak Resi
                            </a>
                        </li>
                        
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person"></i> {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    {{-- Order Show dropdown --}}
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="bi bi-box-seam me-2"></i> Pesanan Saya
                                        @if(auth()->user()->pendingOrders()->count() > 0)
                                            <span class="badge bg-warning float-end mt-1">{{ auth()->user()->pendingOrders()->count() }}</span>
                                        @endif
                                    </a>
                                    
                                    @if(Route::has('dashboard'))
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                                            <i class="bi bi-speedometer me-2"></i> Dashboard
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ url('/') }}">
                                            <i class="bi bi-house me-2"></i> Home
                                        </a>
                                    @endif
                                    
                                    @if(Route::has('profile.edit'))
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="bi bi-person-circle me-2"></i> Profil Saya
                                        </a>
                                    @endif
                                    
                                    <div class="dropdown-divider"></div>
                                    
                                    @if(auth()->user()->is_admin)
                                        <a class="dropdown-item" href="{{ route('admin.orders.index') }}">
                                            <i class="bi bi-speedometer2 me-2"></i> Admin Dashboard
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        {{-- MAIN CONTENT --}}
        <main class="py-4">
            @if(session('success'))
                <div class="container-fluid px-lg-5">
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="container-fluid px-lg-5">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="container-fluid px-lg-5">
                    <div class="alert alert-info alert-dismissible fade show">
                        <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="container-fluid px-lg-5">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill"></i> 
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
        
        {{-- FOOTER --}}
        <footer>
            <div class="container-fluid px-lg-5">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">KrupuKruzzz</h5>
                        <p class="footer-alamat">
                            <i class="bi bi-geo-alt"></i> Dusun Garas RT 0001 RW 0001 Desa Palembon<br>
                            Kecamatan Kanor, Kabupaten Bojonegoro, Jawa Timur, Indonesia
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-2">
                            <i class="bi bi-telephone"></i> 0816-1550-0168<br>
                            <i class="bi bi-envelope"></i> krupukruzzz@gmail.com
                        </p>
                        <p class="mb-0 small">
                            &copy; {{ date('Y') }} KrupuKruzz. Kerupuk Berkualitas Harga Terjangkau
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>