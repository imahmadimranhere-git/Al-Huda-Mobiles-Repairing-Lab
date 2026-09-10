<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Skip the cart entirely — buy a single product right away
    public function buyNow(Product $product)
    {
        if (! $product->isInStock()) {
            return back()->withErrors(['stock' => 'This product is currently out of stock.']);
        }

        session(['buy_now_product_id' => $product->id, 'buy_now_quantity' => 1]);

        return redirect()->route('checkout.index');
    }

    public function index()
    {
        // Buy Now flow: checkout shows just the one product, ignoring the cart
        if (session()->has('buy_now_product_id')) {
            $product = Product::find(session('buy_now_product_id'));

            if (! $product) {
                session()->forget(['buy_now_product_id', 'buy_now_quantity']);
                return redirect()->route('shop.index');
            }

            $quantity = session('buy_now_quantity', 1);

            $items = collect([(object) [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->final_price * $quantity,
            ]]);

            return view('checkout.index', [
                'items' => $items,
                'total' => $items->sum('subtotal'),
                'isBuyNow' => true,
            ]);
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

        return view('checkout.index', [
            'items' => $cart->items,
            'total' => $cart->total,
            'isBuyNow' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string', 'max:500'],
        ]);

        // Buy Now flow: create the order from the single product in session
        if (session()->has('buy_now_product_id')) {
            $product = Product::findOrFail(session('buy_now_product_id'));
            $quantity = session('buy_now_quantity', 1);

            if ($quantity > $product->stock) {
                return back()->withErrors(['stock' => "Not enough stock for {$product->name}."]);
            }

            $order = DB::transaction(function () use ($product, $quantity, $validated) {
                $order = Order::create([
                    'order_number' => OrderNumberService::generate(),
                    'user_id' => auth()->id(),
                    'customer_name' => $validated['customer_name'],
                    'customer_phone' => $validated['customer_phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'total' => $product->final_price * $quantity,
                    'status' => 'pending',
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->final_price,
                    'quantity' => $quantity,
                ]);

                $product->decrement('stock', $quantity);

                return $order;
            });

            session()->forget(['buy_now_product_id', 'buy_now_quantity']);

            return redirect()->route('checkout.confirmation', $order->order_number);
        }

        // Normal cart checkout flow
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty.');
        }

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

                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('checkout.confirmation', $order->order_number);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with('items')
            ->firstOrFail();

        return view('checkout.confirmation', ['order' => $order]);
    }
}