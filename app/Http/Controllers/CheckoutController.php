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

        // MIDTRANS
        $snapToken = null;
        $midtransError = null;
        
        if (config('services.midtrans.server_key')) {
            try {
                \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;
                
                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_number,
                        'gross_amount' => $total,
                    ],
                    'customer_details' => [
                        'first_name' => $request->name,
                        'email' => $request->email, // <=== PAKAI EMAIL DARI INPUTAN
                        'phone' => $request->phone,
                    ]
                ];
                
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                
                // Update order dengan snap token
                $order->update(['snap_token' => $snapToken]);
                
            } catch (\Exception $e) {
                $midtransError = $e->getMessage();
                \Log::error('Midtrans error: ' . $midtransError);
            }
        }
        
        if ($snapToken) {
            // SIMPAN ORDER ID DI SESSION UNTUK PAYMENT PAGE
            session()->put('current_order_id', $order->id);
            
            return view('checkout.payment', compact('snapToken', 'order'));
        } else {
            // FALLBACK: Order berhasil tanpa payment
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_type' => 'manual'
            ]);
            
            return view('checkout.success', compact('order'))
                ->with('info', $midtransError ? 'Payment gateway error, order tetap dibuat.' : 'Order berhasil!');
        }
    }

    // =============== CALLBACK MIDTRANS ===============
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        
        // Generate signature
        $hashed = hash("sha512", 
            $request->order_id . 
            $request->status_code . 
            $request->gross_amount . 
            $serverKey
        );
        
        if ($hashed != $request->signature_key) {
            Log::error('Midtrans callback: Invalid signature');
            return response()->json(['message' => 'Invalid signature'], 403);
        }
        
        $order = Order::where('order_number', $request->order_id)->first();
        
        if (!$order) {
            Log::error('Midtrans callback: Order not found - ' . $request->order_id);
            return response()->json(['message' => 'Order not found'], 404);
        }
        
        $transaction_status = $request->transaction_status;
        $fraud_status = $request->fraud_status;
        
        Log::info('Midtrans Callback: ' . $order->order_number . ' - Status: ' . $transaction_status);
        
        // Update status order berdasarkan callback
        if ($transaction_status == 'capture') {
            if ($fraud_status == 'accept') {
                $order->update([
                    'status' => 'paid',
                    'payment_method' => $request->payment_type,
                    'paid_at' => now(),
                    'transaction_id' => $request->transaction_id
                ]);
            }
        } elseif ($transaction_status == 'settlement') {
            $order->update([
                'status' => 'paid',
                'payment_method' => $request->payment_type,
                'paid_at' => now(),
                'transaction_id' => $request->transaction_id
            ]);
        } elseif ($transaction_status == 'pending') {
            $order->update(['status' => 'pending']);
        } elseif ($transaction_status == 'deny' || 
                 $transaction_status == 'expire' || 
                 $transaction_status == 'cancel') {
            $order->update(['status' => 'failed']);
            // Kembalikan stok jika perlu
        }
        
        return response()->json(['status' => 'success']);
    }

    public function payment(Request $request)
    {
        // Get order from session atau parameter
        $orderId = $request->session()->get('current_order_id');
        
        // Atau ambil dari URL parameter jika ada
        if (!$orderId && $request->has('order_id')) {
            $orderId = $request->order_id;
        }
        
        $order = Order::find($orderId);
        
        if (!$order) {
            return redirect()->route('checkout.index')
                ->with('error', 'Order tidak ditemukan!');
        }
        
        // Ambil snap token dari order
        $snapToken = $order->snap_token;
        
        return view('checkout.payment', compact('snapToken', 'order'));
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

    //Travking Update
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
        'status' => 'processed', // <- INI YANG DIPERBAIKI
        'shipped_at' => now(),
    ]);
    
    return redirect()->back()
        ->with('success', 'Nomor resi berhasil diperbarui. Status pesanan: Diproses');
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