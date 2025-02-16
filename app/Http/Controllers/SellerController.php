<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Get seller-specific stats
        $totalProducts = Product::where('user_id', $user->id)->count();

        // Fix the order queries to use order_items
        $totalOrders = Order::whereHas('orderItems.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'completed')->count();

        $totalRevenue = Order::whereHas('orderItems.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->where('status', 'completed')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.user_id', $user->id)
            ->sum(DB::raw('order_items.quantity * order_items.price'));

        // Get seller's products
        $recentProducts = Product::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get recent orders for seller's products
        $recentOrders = Order::whereHas('orderItems.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['orderItems.product', 'user'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) use ($user) {
                // Calculate seller_total for this specific order
                $sellerTotal = $order->orderItems
                    ->whereIn('product.user_id', [$user->id])
                    ->sum(function ($item) {
                        return $item->quantity * $item->price;
                    });

                return array_merge($order->toArray(), [
                    'seller_total' => $sellerTotal
                ]);
            });

        return Inertia::render('Seller/Dashboard', [
            'stats' => [
                'totalProducts' => $totalProducts,
                'totalOrders' => $totalOrders,
                'totalRevenue' => $totalRevenue,
                'averageOrderValue' => $totalOrders > 0 ? $totalRevenue / $totalOrders : 0,
            ],
            'recentProducts' => $recentProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
