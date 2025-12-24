<?php
// app/Http/Controllers/TrackingController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index'); // Form input
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:50',
            'email' => 'required|email|max:100'
        ]);
        
        $order = Order::where('tracking_number', $request->tracking_number)
                      ->whereHas('user', function($q) use ($request) {
                          $q->where('email', $request->email);
                      })->first();
        
        if ($order) {
            return view('tracking.result', compact('order'));
        }
        
        return back()->with('error', 'Resi tidak ditemukan. Periksa nomor resi dan email Anda.');
    }
}