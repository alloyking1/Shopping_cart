<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Create an order (checkout) from the authenticated user's cart.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Verify stock availability before starting transaction
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                return back()->with('error', "Not enough stock for {$item->product->name}.");
            }
        }

        $order = null;

        DB::transaction(function () use ($user, $cartItems, &$order) {
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price_at_purchase' => $item->product->price,
                ]);

                // decrease stock
                $product = $item->product;
                $product->stock_quantity = max(0, $product->stock_quantity - $item->quantity);
                $product->save();
            }

            // clear user's cart
            CartItem::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully.');
    }

    /**
     * Show order confirmation page.
     */
    public function show(Order $order): Response
    {
        // Ensure the authenticated user owns this order
        $user = auth()->user();

        if (!$user || $user->id !== $order->user_id) {
            abort(403);
        }

        $order->load('orderItems.product');

        // Prepare a clean data structure for Inertia
        $orderData = [
            'id' => $order->id,
            'total_amount' => $order->total_amount,
            'created_at' => $order->created_at,
            'order_items' => $order->orderItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'price_at_purchase' => $item->price_at_purchase,
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                    ],
                ];
            })->values(),
        ];

        return Inertia::render('Orders/Show', [
            'order' => $orderData,
        ]);
    }
}
