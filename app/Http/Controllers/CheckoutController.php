<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function index()
    {
        return Inertia::render('Checkout/Index');
    }

    /**
     * Process the checkout
     */
    public function process(CheckoutRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'full_name' => $request->input('shipping_details.full_name'),
                'email' => $request->input('shipping_details.email'),
                'phone' => $request->input('shipping_details.phone'),
                'address' => $request->input('shipping_details.address'),
                'city' => $request->input('shipping_details.city'),
                'state' => $request->input('shipping_details.state'),
                'postal_code' => $request->input('shipping_details.postal_code'),
                'country' => $request->input('shipping_details.country'),
                'subtotal' => $request->input('subtotal'),
                'tax' => $request->input('tax'),
                'total' => $request->input('total'),
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($request->input('cart_items') as $item) {
                $product = Product::findOrFail($item['id']);

                // Verify the product is still available and has sufficient stock
                if (!$product->isAvailable() || $product->stock < $item['quantity']) {
                    throw new \Exception("Product {$product->name} is no longer available or has insufficient stock.");
                }

                Order::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                ]);

                // Reduce the product stock
                $product->decrement('stock', $item['quantity']);
            }

            // Process payment (implement your payment gateway logic here)
            $paymentSuccessful = $this->processPayment($order);

            if (!$paymentSuccessful) {
                throw new \Exception('Payment processing failed.');
            }

            // Update order status
            $order->update(['status' => 'paid']);

            DB::commit();

            // Send order confirmation email
            $this->sendOrderConfirmation($order);

            return response()->json([
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to process order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process the payment
     */
    private function processPayment(Order $order)
    {
        // Implement your payment gateway logic here
        // This is a placeholder that always returns true
        // Replace with actual payment processing code
        return true;
    }

    /**
     * Send order confirmation email
     */
    private function sendOrderConfirmation(Order $order)
    {
        // Implement your email sending logic here
        // You might want to use Laravel's Mail facade or a mailing service
        try {
            // Mail::to($order->email)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email: ' . $e->getMessage());
        }
    }

    public function store(CheckoutRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
            ]);

            $subtotal = 0;

            // Process each item and create order items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);

                // Check stock availability
                if (!$product->isAvailable() || $product->stock < $item['quantity']) {
                    throw new \Exception("Product {$product->name} is no longer available or has insufficient stock.");
                }

                // Create order item
                $itemTotal = $product->price * $item['quantity'];
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $itemTotal
                ]);

                // Update product stock
                $product->decrement('stock', $item['quantity']);

                $subtotal += $itemTotal;
            }

            // Calculate totals
            $tax = $subtotal * 0.10; // 10% tax rate - adjust as needed
            $total = $subtotal + $tax;

            // Update order with totals
            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total
            ]);

            // Process payment
            $paymentSuccessful = $this->processPayment($order);

            if (!$paymentSuccessful) {
                throw new \Exception('Payment processing failed.');
            }

            // Update order status
            $order->update(['status' => 'paid']);

            DB::commit();

            // Send order confirmation email
            $this->sendOrderConfirmation($order);

            return redirect()->route('orders.show', ['order' => $order->id])
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to process order: ' . $e->getMessage())
                ->withInput();
        }
    }
}
