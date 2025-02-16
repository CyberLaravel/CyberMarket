<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get admin stats
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalSales = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');

        // Get top sellers
        $topSellers = User::withCount(['products', 'orders'])
            ->withSum(['orders as revenue' => function ($query) {
                $query->where('status', 'completed');
            }], 'total')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        // Get recent orders
        $recentOrders = Order::with(['product', 'user'])
            ->latest()
            ->take(10)
            ->get();

        // Get sales by day for the last 7 days
        $salesByDay = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'totalProducts' => $totalProducts,
                'totalUsers' => $totalUsers,
                'totalSales' => $totalSales,
                'totalRevenue' => $totalRevenue,
            ],
            'topSellers' => $topSellers,
            'recentOrders' => $recentOrders,
            'salesByDay' => $salesByDay,
        ]);
    }
}
