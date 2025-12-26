<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        // PAKAI SESSION, BUKAN DATABASE
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Keranjang Anda kosong! Silakan tambah produk dulu.');
        }
        
        $total = 0;
        foreach ($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $user = auth()->user();
        $hasCompleteAddress = $user->phone && $user->address && $user->city 
                            && $user->province && $user->postal_code;
        
        return view('checkout.index', compact('cart', 'total', 'user', 'hasCompleteAddress'));
    }

    public function process(Request $request)
    {
        // DEBUG: Cek apa yang masuk
        \Log::info('Checkout Process Request:', $request->all());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255', 
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10'
        ]);
        
        // DEBUG: Cek session cart
        $cart = session()->get('cart', []);
        \Log::info('Cart in process:', $cart);
        
        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Keranjang Anda kosong!');
        }
        
        // Update alamat user - PASTIKAN KOLOM ADA DI DATABASE
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email, // Update email user juga jika perlu
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code
        ]);
        
        \Log::info('User updated:', $user->toArray());
        
        // Hitung total
        $total = 0;
        foreach ($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        if ($total <= 0) {
            return redirect()->route('products.index')
                ->with('error', 'Total tidak valid!');
        }

        try {
            DB::beginTransaction(); 

            // CREATE ORDER - PASTIKAN SEMUA KOLOM ADA
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'name' => $request->name,
                'email' => $request->email, // <=== INI YANG DITAMBAHKAN!
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'total_amount' => $total,
                'status' => 'pending',
                // TAMBAH KOLOM JIKA PERLU
                'snap_token' => null,
                'payment_type' => null,
                'transaction_id' => null,
                'paid_at' => null,
            ]);
            
            \Log::info('Order created:', $order->toArray());

            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);

                if (!$product) {
                    DB::rollBack(); 
                    return redirect()->back()
                        ->with('error', 'Produk tidak ditemukan!');
                }

                if ($product->stock < $item['quantity']) {
                    DB::rollBack(); 
                    return redirect()->back()
                        ->with('error', 'Stok ' . $product->name . ' tidak cukup!');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);
                
                $product->decrement('stock', $item['quantity']);
            }

            // HAPUS CART SETELAH BERHASIL
            session()->forget('cart');
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }

        // SIMPAN ORDER ID DI SESSION UNTUK PAYMENT PAGE
        session()->put('current_order_id', $order->id);
        
        return redirect()->route('checkout.payment', ['order_id' => $order->id]);
    }

    /**
     * Upload Payment Proof
     */
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bank_name' => 'required|string|max:50'
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $order->update([
                'payment_proof' => $path,
                'bank_name' => $request->bank_name,
                'status' => 'pending' // Tetap pending sampai dikonfirmasi admin
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu konfirmasi admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran.');
    }


    public function payment(Request $request)
    {
        $orderId = $request->query('order_id') ?? $request->session()->get('current_order_id');
        
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        // Daftar rekening bank (bisa dipindah ke config nanti)
        $banks = [
            ['name' => 'DANA', 'number' => '081615500168', 'holder' => 'Achmad Machrus Ali'],
            ['name' => 'Bank Jago', 'number' => '100641390135', 'holder' => 'Achmad Machrus Ali']
        ];
        
        return view('checkout.payment', compact('order', 'banks'));
    }

    // =============== ADMIN ORDERS ===============
    public function adminOrders()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }
    
    // =============== TEST MIDTRANS ===============
    public function testMidtrans()
    {
        $serverKey = config('services.midtrans.server_key');
        
        if (empty($serverKey)) {
            return "Server Key kosong! Isi di .env";
        }
        
        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = false;
        
        $params = [
            'transaction_details' => [
                'order_id' => 'TEST-' . time(),
                'gross_amount' => 10000,
            ],
            'customer_details' => [
                'first_name' => 'Test',
                'email' => 'test@example.com',
                'phone' => '08123456789',
            ]
        ];
        
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            return view('checkout.test', compact('snapToken'));
            
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        // Debug: cek apakah ada order_id
        \Log::info('Checkout success accessed with order_id: ' . $request->query('order_id'));
        
        $orderId = $request->query('order_id');
        
        if ($orderId) {
            $order = Order::where('order_number', $orderId)->first();
        } else {
            $order = Order::where('user_id', auth()->id())
                ->latest()
                ->first();
        }
        
        if (!$order) {
            return redirect()->route('products.index')
                ->with('error', 'Pesanan tidak ditemukan');
        }
        
        // Debug: cek order data
        \Log::info('Order found: ' . $order->order_number);
        
        return view('checkout.success', compact('order'));
    }

    // =============== SHOW ORDER DETAIL ===============
    public function showOrder($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Print Invoice
    public function printInvoice($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
            'paid_at' => ($request->status == 'processing' && !$order->paid_at) ? now() : $order->paid_at
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:180',
            'shipping_courier' => 'required|string|max:50',
            'shipping_service' => 'nullable|string|max:50',
        ]);
        
        $order = Order::findOrFail($id);
        
        $order->update([
            'tracking_number' => $request->tracking_number,
            'shipping_courier' => $request->shipping_courier,
            'shipping_service' => $request->shipping_service ?? 'REG',
            'status' => 'shipped', // Jika resi diinput, status jadi dikirim
            'shipped_at' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Nomor resi berhasil diperbarui.');
    }

    //ORDER DETAIL FOR USERS 
    public function orderDetail($id)
    {
        $order = Order::with('items')->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
            
        return view('orders.show', compact('order'));
    }

    /**
     * Delete order (Admin)
     */
    public function destroyOrder($id)
    {
        try {
            $order = Order::findOrFail($id);
            
            $order->delete();
            
            return redirect()->route('admin.orders.index')
                ->with('success', 'Pesanan #' . $id . ' berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }
}