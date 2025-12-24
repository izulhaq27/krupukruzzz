<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'KrupuKruzzz')); ?></title>
    
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
        
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-lg-5"> <!-- Full Width Navbar -->
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" 
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
                            <a class="nav-link" href="<?php echo e(route('products.index')); ?>">
                                <i class="bi bi-shop"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('categories.index')); ?>">
                        <i class="bi bi-tags"></i> Kategori
                        </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('cart.index')); ?>">
                                <i class="bi bi-cart3"></i> Keranjang
                                <?php if(session('cart') && count(session('cart')) > 0): ?>
                                    <span class="badge cart-badge"><?php echo e(count(session('cart'))); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        
                        
                        <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('orders.index')); ?>">
                                <i class="bi bi-box-seam"></i> Pesanan Saya
                                <?php
                                    $pendingCount = 0;
                                    if (auth()->check()) {
                                        $pendingCount = auth()->user()->pendingOrders()->count();
                                    }
                                ?>
                                <?php if($pendingCount > 0): ?>
                                    <span class="badge orders-badge"><?php echo e($pendingCount); ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('tracking.index')); ?>">
                                <i class="bi bi-truck"></i> Lacak Resi
                            </a>
                        </li>
                        
                        <?php if(auth()->guard()->guest()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person"></i> <?php echo e(Auth::user()->name); ?>

                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    
                                    <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                        <i class="bi bi-box-seam me-2"></i> Pesanan Saya
                                        <?php if(auth()->user()->pendingOrders()->count() > 0): ?>
                                            <span class="badge bg-warning float-end mt-1"><?php echo e(auth()->user()->pendingOrders()->count()); ?></span>
                                        <?php endif; ?>
                                    </a>
                                    
                                    <?php if(Route::has('dashboard')): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">
                                            <i class="bi bi-speedometer me-2"></i> Dashboard
                                        </a>
                                    <?php else: ?>
                                        <a class="dropdown-item" href="<?php echo e(url('/')); ?>">
                                            <i class="bi bi-house me-2"></i> Home
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(Route::has('profile.edit')): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                                            <i class="bi bi-person-circle me-2"></i> Profil Saya
                                        </a>
                                    <?php endif; ?>
                                    
                                    <div class="dropdown-divider"></div>
                                    
                                    <?php if(auth()->user()->is_admin): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('admin.orders.index')); ?>">
                                            <i class="bi bi-speedometer2 me-2"></i> Admin Dashboard
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    <?php endif; ?>
                                    
                                    <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        
        
        <main class="py-4">
            <?php if(session('success')): ?>
                <div class="container-fluid px-lg-5">
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill"></i> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="container-fluid px-lg-5">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill"></i> <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="container-fluid px-lg-5">
                    <div class="alert alert-info alert-dismissible fade show">
                        <i class="bi bi-info-circle-fill"></i> <?php echo e(session('info')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="container-fluid px-lg-5">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill"></i> 
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
        
        
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
                            &copy; <?php echo e(date('Y')); ?> KrupuKruzz. Kerupuk Berkualitas Harga Terjangkau
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
</html><?php /**PATH C:\laragon\www\Umkm_Krupuk\resources\views/layouts/app.blade.php ENDPATH**/ ?>