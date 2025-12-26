<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController; 
use App\Models\Order;

/*
 PUBLIC ROUTES
*/

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Products & Categories
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Cart & Tracking
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/track', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/track', [TrackingController::class, 'track'])->name('tracking.check');

// Auth (Bawaan Laravel)
Auth::routes(['register' => true]);

// Admin Login (Tanpa Middleware Auth)
Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Midtrans & Payment Callback
Route::get('/test-midtrans', [CheckoutController::class, 'testMidtrans']);
Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');

/*
 USER ROUTES (Auth Required)
*/

Route::middleware(['auth'])->group(function () {
    // Cart Actions
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout Process
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::get('/checkout/success', function (\Illuminate\Http\Request $request) {
        $orderId = $request->query('order_id');
        $order = $orderId ? Order::where('order_number', $orderId)->first() : Order::where('user_id', auth()->id())->latest()->first();
        
        if (!$order) {
            return redirect()->route('products.index')->with('error', 'Pesanan tidak ditemukan.');
        }
        return view('checkout.success', ['order' => $order]);
    })->name('checkout.success');
    
    // User Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order_number}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order_number}/invoice', [OrderController::class, 'invoice'])->name('invoice');
        Route::post('/{order_number}/pay', [OrderController::class, 'pay'])->name('pay');
        Route::post('/{order_number}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{order_number}/confirm-received', [OrderController::class, 'confirmReceived'])->name('confirm-received');
        Route::post('/{order_number}/reorder', [OrderController::class, 'reorder'])->name('reorder');
        Route::get('/{order_number}/track', [OrderController::class, 'track'])->name('track');
        Route::delete('/{order_number}', [OrderController::class, 'destroy'])->name('destroy');
        
        // Filter Status
        Route::get('/status/pending', [OrderController::class, 'pending'])->name('pending');
        Route::get('/status/active', [OrderController::class, 'active'])->name('active');
        Route::get('/status/completed', [OrderController::class, 'completed'])->name('completed');
    });
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

/*
ADMIN ROUTES (Admin Auth Required)
*/

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // ========== TAMBAHKAN INI: Admin Categories ==========
    Route::resource('categories', AdminCategoryController::class);
    // ====================================================
    
    // Admin Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [CheckoutController::class, 'adminOrders'])->name('index');
        Route::get('/{id}', [CheckoutController::class, 'showOrder'])->name('show');
        Route::get('/{id}/print', [CheckoutController::class, 'printInvoice'])->name('print');
        Route::post('/{id}/tracking', [CheckoutController::class, 'updateTracking'])->name('update-tracking');
        Route::post('/{id}/status', [CheckoutController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{id}', [CheckoutController::class, 'destroyOrder'])->name('destroy');
    });
    
    // Admin Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    
    // Admin Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Admin Settings
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});