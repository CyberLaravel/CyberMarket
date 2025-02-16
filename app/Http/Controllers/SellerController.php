<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SellerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Get seller-specific stats
        $totalProducts = Product::where('user_id', $user->id)->count();
        $totalSales = Order::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'completed')->count();
        $totalRevenue = Order::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'completed')->sum('total');

        // Get seller's products
        $recentProducts = Product::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get recent orders for seller's products
        $recentOrders = Order::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Seller/Dashboard', [
            'stats' => [
                'totalProducts' => $totalProducts,
                'totalSales' => $totalSales,
                'totalRevenue' => $totalRevenue,
                'averageOrderValue' => $totalSales > 0 ? $totalRevenue / $totalSales : 0,
            ],
            'recentProducts' => $recentProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
