<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderShippedNotification;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // app/Http/Controllers/Admin/OrderController.php
    public function update(Request $request, Order $order)
    {
    $validated = $request->validate([
        'status' => 'required|in:pending,paid,processing,shipped,delivered,cancelled',
        'tracking_number' => 'nullable|string|max:50',
        'shipping_courier' => 'nullable|string|max:50',
        'shipping_service' => 'nullable|string|max:50',
        'shipping_cost' => 'nullable|numeric',
        'shipped_at' => 'nullable|date',
        'estimated_delivery' => 'nullable|date',
    ]);
    
    // Jika status berubah ke "shipped" dan ada tracking number
    if ($request->status == 'shipped' && $request->tracking_number) {
        $validated['shipped_at'] = now();
        $order->user->notify(new OrderShippedNotification($order));
    }
    
    $order->update($validated);
    
    return redirect()->back()->with('success', 'Pesanan berhasil diperbarui');
    }

    
}


