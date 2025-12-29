<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Query dasar
        $query = $user->orders()->with(['items', 'items.product'])->latest();
        
        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $orders = $query->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show($orderNumber)
    {
        $user = Auth::user();
        
        try {
            // Cari order berdasarkan order_number dan milik user yang login
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', $user->id)
                ->with(['items', 'items.product', 'user'])
                ->firstOrFail();
            
            return view('orders.show', compact('order'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.');
        }
    }

    /**
     * Show active orders (not delivered/cancelled)
     */
    public function active()
    {
        try {
            $user = Auth::user();
            
            // Pastikan method activeOrders() ada di model User
            if (!method_exists($user, 'activeOrders')) {
                // Fallback jika method tidak ada
                $orders = $user->orders()
                    ->whereNotIn('status', ['completed', 'cancelled'])
                    ->with(['items', 'items.product'])
                    ->latest()
                    ->paginate(10);
            } else {
                $orders = $user->activeOrders()
                    ->with(['items', 'items.product'])
                    ->latest()
                    ->paginate(10);
            }
            
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show completed orders
     */
    public function completed()
    {
        try {
            $user = Auth::user();
            
            // Pastikan method completedOrders() ada di model User
            if (!method_exists($user, 'completedOrders')) {
                // Fallback jika method tidak ada
                $orders = $user->orders()
                    ->where('status', 'completed')
                    ->with(['items', 'items.product'])
                    ->latest()
                    ->paginate(10);
            } else {
                $orders = $user->completedOrders()
                    ->with(['items', 'items.product'])
                    ->latest()
                    ->paginate(10);
            }
            
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show pending payment orders
     */
    public function pending()
    {
        try {
            $user = Auth::user();
            
            // Pastikan method pendingOrders() ada di model User
            if (!method_exists($user, 'pendingOrders')) {
                // Fallback jika method tidak ada
                $orders = $user->orders()
                    ->where('status', 'pending')
                    ->with(['items', 'items.product'])
                    ->latest()
                    ->paginate(10);
            } else {
                $orders = $user->pendingOrders()
                    ->with(['items', 'items.product'])
                    ->latest()
                    ->paginate(10);
            }
            
            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Process payment for an order
     */
    public function pay(Request $request, $orderNumber)
    {
        try {
            $user = Auth::user();
            
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', $user->id)
                ->firstOrFail();
            
            // Cek jika order sudah dibayar
            if ($order->status !== 'pending') {
                return redirect()->back()
                    ->with('error', 'Pesanan sudah diproses atau dibayar.');
            }
            
            // Generate Snap Token jika belum ada
            if (!$order->snap_token) {
                if (config('services.midtrans.server_key')) {
                    \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
                    \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
                    \Midtrans\Config::$isSanitized = true;
                    \Midtrans\Config::$is3ds = true;
                    
                    $params = [
                        'transaction_details' => [
                            'order_id' => $order->order_number,
                            'gross_amount' => $order->total_amount,
                        ],
                        'customer_details' => [
                            'first_name' => $user->name,
                            'email' => $user->email,
                            'phone' => $order->phone,
                        ]
                    ];
                    
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    $order->update(['snap_token' => $snapToken]);
                }
            }
            
            return redirect()->route('checkout.payment', ['order_id' => $order->id]);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

/**
 * Cancel an order
 */
    public function cancel(Request $request, $orderNumber)
    {
    try {
        $user = Auth::user();
        
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $user->id)
            ->firstOrFail();
        
        // Cek jika order bisa dibatalkan
        $cancellableStatuses = ['pending', 'paid', 'processed'];
        
        if (!in_array($order->status, $cancellableStatuses)) {
            return redirect()->back()
                ->with('error', 'Pesanan tidak dapat dibatalkan pada tahap ini.');
        }
        
        // Update status menjadi cancelled
        $order->update([
            'status' => 'cancelled',
            'notes' => $request->notes ?? 'Dibatalkan oleh pelanggan'
        ]);
        
        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Pesanan berhasil dibatalkan.');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
    }
}
    /**
     * Track order
     */
    public function track($orderNumber)
    {
        try {
            $user = Auth::user();
            
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', $user->id)
                ->firstOrFail();
            
            // Cek status constants
            $shippedStatus = defined('App\Models\Order::STATUS_SHIPPED') 
                ? Order::STATUS_SHIPPED 
                : 'shipped';
            $deliveredStatus = defined('App\Models\Order::STATUS_DELIVERED') 
                ? Order::STATUS_DELIVERED 
                : 'completed';
            
            // Pastikan order sudah dikirim
            if (!in_array($order->status, [$shippedStatus, $deliveredStatus])) {
                return redirect()->back()
                    ->with('error', 'Pesanan belum dikirim atau tidak memiliki nomor resi.');
            }
            
            return view('orders.track', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan atau terjadi kesalahan.');
        }
    }

    /**
     * Confirm order received
     */
    public function confirmReceived($orderNumber)
    {
        try {
            $user = Auth::user();
            
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', $user->id)
                ->firstOrFail();
            
            // Cek status constants
            $shippedStatus = defined('App\Models\Order::STATUS_SHIPPED') 
                ? Order::STATUS_SHIPPED 
                : 'shipped';
            $deliveredStatus = defined('App\Models\Order::STATUS_DELIVERED') 
                ? Order::STATUS_DELIVERED 
                : 'completed';
            
            // Pastikan status shipped
            if ($order->status !== $shippedStatus) {
                return redirect()->back()
                    ->with('error', 'Pesanan belum dikirim atau sudah diterima.');
            }
            
            // Update status menjadi delivered
            $order->update([
                'status' => $deliveredStatus,
                'delivered_at' => now()
            ]);
            
            return redirect()->route('orders.show', $order->order_number)
                ->with('success', 'Terima kasih! Pesanan telah dikonfirmasi diterima.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengkonfirmasi pesanan: ' . $e->getMessage());
        }
    }



    /**
     * Print invoice
     */
    public function invoice($orderNumber)
    {
        try {
            $user = Auth::user();
            
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', $user->id)
                ->with(['items', 'items.product', 'user'])
                ->firstOrFail();
            
            // Cek apakah view invoice ada
            if (!view()->exists('orders.invoice')) {
                // Fallback ke show page dengan pesan
                return redirect()->route('orders.show', $order->order_number)
                    ->with('info', 'Fitur invoice sedang dalam pengembangan.');
            }
            
            return view('orders.invoice', compact('order'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('orders.show', $orderNumber)
                ->with('error', 'Gagal menampilkan invoice: ' . $e->getMessage());
        }
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoice($orderNumber)
    {
        try {
            $user = Auth::user();
            
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', $user->id)
                ->with(['items', 'items.product', 'user'])
                ->firstOrFail();
            
            // TODO: Implement PDF generation
            return redirect()->back()
                ->with('info', 'Fitur download invoice sedang dalam pengembangan.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mendownload invoice: ' . $e->getMessage());
        }
    }

    /**
     * Reorder from existing order
     */
    public function reorder($orderNumber)
    {
        try {
            $user = Auth::user();
            
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', $user->id)
                ->with('items')
                ->firstOrFail();
            
            $cart = session()->get('cart', []);
            $addedCount = 0;
            $skippedCount = 0;

            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);

                // Skip if product missing or out of stock
                if (!$product || $product->stock <= 0) {
                    $skippedCount++;
                    continue;
                }

                // Decide quantity (use order quantity but cap at current stock)
                $qtyToAdd = min($item->quantity, $product->stock);

                if (isset($cart[$product->id])) {
                    $cart[$product->id]['quantity'] += $qtyToAdd;
                } else {
                    $cart[$product->id] = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $qtyToAdd,
                        'image' => $product->image
                    ];
                }
                $addedCount++;
            }

            session()->put('cart', $cart);
            
            if ($addedCount > 0) {
                $msg = $addedCount . ' produk dari pesanan lama telah ditambahkan ke keranjang.';
                if ($skippedCount > 0) {
                    $msg .= ' (' . $skippedCount . ' produk dilewati karena stok habis)';
                }
                return redirect()->route('cart.index')->with('success', $msg);
            } else {
                return redirect()->back()->with('error', 'Gagal memproses reorder: Produk mungkin sudah tidak tersedia atau stok habis.');
            }
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal melakukan reorder: ' . $e->getMessage());
        }
    }

    /**
     * Delete an order (only if cancelled)
     */
    public function destroy($orderNumber)
    {
        try {
            $user = Auth::user();
            
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', $user->id)
                ->firstOrFail();
            
            // Only allow deletion of cancelled or failed orders
            if (!in_array($order->status, ['cancelled', 'failed'])) {
                return redirect()->back()
                    ->with('error', 'Hanya pesanan yang dibatalkan atau gagal yang dapat dihapus dari riwayat.');
            }
            
            $order->delete();
            
            return redirect()->route('orders.index')
                ->with('success', 'Riwayat pesanan berhasil dihapus.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus riwayat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Set payment method to manual transfer
     */
    public function setManualPayment($orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $order->update([
                'payment_type' => 'manual_transfer',
                'status' => 'pending'
            ]);

            return redirect()->route('checkout.success', ['order_id' => $order->order_number])
                ->with('success', 'Metode pembayaran diubah ke Transfer Bank Manual. Silakan lakukan pembayaran dan unggah bukti.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah metode pembayaran.');
        }
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, $orderNumber)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_name' => 'required|string|max:100',
        ]);

        try {
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $filename = 'proof_' . $order->order_number . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('payment_proofs', $filename, 'public');

                $order->update([
                    'payment_proof' => $path,
                    'bank_name' => $request->bank_name,
                    'payment_type' => 'manual_transfer'
                ]);

                return redirect()->route('orders.show', $order->order_number)
                    ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
            }

            return redirect()->back()->with('error', 'Berkas tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah bukti: ' . $e->getMessage());
        }
    }
}