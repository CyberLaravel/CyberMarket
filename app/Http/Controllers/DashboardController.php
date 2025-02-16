<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get stats
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalSales = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');

        // Get recent products
        $recentProducts = Product::with('seller')
            ->latest()
            ->take(6)
            ->get();

        // Get user's recent orders
        $recentOrders = Order::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();



        return Inertia::render('Dashboard', [
            'stats' => [
                'totalProducts' => $totalProducts,
                'totalUsers' => $totalUsers,
                'totalSales' => $totalSales,
                'totalRevenue' => $totalRevenue,
            ],
            'recentProducts' => $recentProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
