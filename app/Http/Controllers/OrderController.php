<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\OrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function __construct()
    {
        // $this->authorizeResource(Order::class, 'order');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('product')->latest()->get();
        return Inertia::render('Orders/Index', ['orders' => $orders]);
    }

    public function create()
    {
        return Inertia::render('Orders/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'amount' => $product->price * $request->quantity,
            'status' => 'Pending',
        ]);

        // Notify user
        $order->user->notify(new OrderPlaced([
            'order_id' => $order->id,
            'amount' => $order->amount,
            'status' => $order->status,
        ]));

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return Inertia::render('Orders/Show', ['order' => $order]);
    }

    public function edit(Order $order)
    {
        return Inertia::render('Orders/Edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->validated());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}
