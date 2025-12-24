<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan semua order (untuk admin)
     */

  public function __construct()
{
    $this->middleware('auth');
    $this->middleware(function ($request, $next) {
        if (auth()->user()->is_admin != 1) {
            abort(403, 'Hanya admin yang boleh mengakses.');
        }
        return $next($request);
    });
}

    public function orders()
    {
        $orders = Order::with('user')
                      ->latest()
                      ->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail order
     */
    public function orderDetail($id)
    {
        $order = Order::with(['user', 'items'])
                      ->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update nomor resi pengiriman
     */
    public function updateTracking(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'tracking_number' => 'required|string|max:50',
            'shipping_courier' => 'required|string|in:jne,tiki,pos,sicepat,jnt,anteraja,ninja'
        ]);
        
        // Update data pengiriman
        $order->update([
            'tracking_number' => $request->tracking_number,
            'shipping_courier' => $request->shipping_courier,
            'shipping_service' => $request->shipping_service,
            'shipped_at' => now(),
            'status' => 'shipped' // Ubah status menjadi "dikirim"
        ]);
        
        return back()->with('success', 'Nomor resi berhasil disimpan!');
    }
}