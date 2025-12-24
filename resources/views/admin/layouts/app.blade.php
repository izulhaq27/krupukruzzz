<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - KrupuKruzz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #F1F5F9; /* Light Gray Background */
            font-family: 'Inter', 'Segoe UI', sans-serif;
            overflow-x: hidden;
            color: #64748b;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px; /* Slightly wider */
            height: 100vh;
            background: #1C2434; /* TailAdmin Dark Blue */
            color: #dee4ee;
            z-index: 1200;
            transition: .3s ease;
            border-right: none;
        }

        .sidebar-header {
            padding: 24px 32px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 32px;
            color: #dee4ee;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #333A48;
            color: #ffffff;
            border-left: none; /* Removed border */
        }
        
        .sidebar a.active {
            position: relative;
        }

        /* ================= MAIN ================= */
        .main-content {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            transition: .3s ease;
            background: #F1F5F9;
        }

        .topbar {
            background: #ffffff;
            padding: 14px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #e5e7eb;
            color: #333333;
        }

        /* ================= OVERLAY ================= */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.7);
            z-index: 1100;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* ================= BUTTON ================= */
        .btn-orange {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            border: none;
        }

        .btn-orange:hover {
            background: linear-gradient(135deg, #059669, #047857);
            color: #ffffff;
        }

        /* ================= MOBILE ================= */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h5 class="fw-bold mb-0 text-white fs-6">Admin Panel KrupuKruzz</h5>
    </div>

    <div class="px-4 mb-2 text-muted text-uppercase" style="font-size: 11px; letter-spacing: 1px;">Menu</div>

    <a href="{{ route('admin.dashboard') }}"
       class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Dashboard
    </a>
    
    <a href="{{ route('admin.categories.index') }}" 
       class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <i class="bi bi-tags-fill"></i>
        <span>Kategori</span>
    </a>

    <a href="{{ route('admin.products.index') }}"
       class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam-fill"></i> Produk
    </a>

    <a href="{{ route('admin.orders.index') }}"
       class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="bi bi-cart-fill"></i> Pesanan
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Users
    </a>

    <div class="mt-auto p-4">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="btn w-100 fw-bold text-start text-white" style="background: transparent; border: 1px solid #333A48;">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- OVERLAY -->
<div class="sidebar-overlay" id="overlay"></div>

<!-- MAIN -->
<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar d-flex justify-content-between align-items-center bg-white" style="box-shadow: 0 1px 4px rgba(0,0,0,0.05); border: none;">
        <div class="d-flex align-items-center">
            <button class="btn d-md-none border-0 fs-4" id="toggle" style="color: #64748b;">
                <i class="bi bi-list"></i>
            </button>
            
            <!-- Search Removed -->
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="text-end d-none d-sm-block line-height-sm">
                    <span class="d-block fw-bold text-dark" style="font-size: 14px;">Admin Panel</span>
                </div>
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="container-fluid px-4 py-4">
        @yield('content')
    </div>
</div>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggle = document.getElementById('toggle');

    if (toggle) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }
});
</script>

</body>
</html>