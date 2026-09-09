<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Show the checkout form (shipping details + order summary)
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        return view('checkout.index', ['cart' => $cart]);
    }

    // Place the order: create Order + OrderItems, reduce stock, empty the cart
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string', 'max:500'],
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        // Make sure stock is still available before placing the order
        foreach ($cart->items as $item) {
            if ($item->quantity > $item->product->stock) {
                return back()->withErrors([
                    'stock' => "Not enough stock for {$item->product->name}. Only {$item->product->stock} left.",
                ]);
            }
        }

        $order = DB::transaction(function () use ($cart, $validated) {
            $order = Order::create([
                'order_number' => OrderNumberService::generate(),
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'total' => $cart->total,
                'status' => 'pending',
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->final_price,
                    'quantity' => $item->quantity,
                ]);

                // Reduce stock now that the order is confirmed
                $item->product->decrement('stock', $item->quantity);
            }

            // Empty the cart now that it's been turned into an order
            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('checkout.confirmation', $order->order_number);
    }

    // Show order confirmation
    public function confirmation(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with('items')
            ->firstOrFail();

        return view('checkout.confirmation', ['order' => $order]);
    }
}