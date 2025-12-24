<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
        $totalRevenue = Order::where('status', 'paid')->sum('total_amount');
        
        // Ambil 10 order terbaru dengan relasi user
        $latestOrders = Order::with('user')
                            ->latest()
                            ->take(10)
                            ->get();

        // 1. Chart Data: Monthly Revenue (Current Year)
        $monthlyRevenue = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthRevenue = Order::where('status', 'paid')
                                ->whereYear('created_at', Carbon::now()->year)
                                ->whereMonth('created_at', $m)
                                ->sum('total_amount');
            $monthlyRevenue[] = $monthRevenue; // Values in Rupiah
        }

        // 2. Chart Data: Daily Sales (This Week: Mon-Sun)
        $dailySales = [];
        $startOfWeek = Carbon::now()->startOfWeek();
        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $count = Order::whereDate('created_at', $day)->count();
            $dailySales[] = $count;
        }

        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'newOrders'     => Order::where('status', 'pending')->count(),
            'totalUsers'    => User::count(),
            'todayOrders'   => $todayOrders,
            'totalRevenue'  => $totalRevenue,
            'latestOrders'  => $latestOrders,
            'monthlyRevenue'=> $monthlyRevenue,
            'dailySales'    => $dailySales,
        ]);
    }
}