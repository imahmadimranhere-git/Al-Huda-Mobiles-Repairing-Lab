<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Get (or create) the logged-in user's cart
    private function getCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function index()
    {
        $cart = $this->getCart();
        $cart->load('items.product');

        return view('cart.index', ['cart' => $cart]);
    }

    // Add a product to the cart, or increase quantity if it's already there
    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = $validated['quantity'] ?? 1;

        if (! $product->isInStock()) {
            return back()->withErrors(['stock' => 'This product is currently out of stock.']);
        }

        $cart = $this->getCart();

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('status', 'Added to cart.');
    }

    // Update quantity for one cart item
    public function update(Request $request, $itemId)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCart();
        $item = $cart->items()->where('id', $itemId)->firstOrFail();
        $item->update(['quantity' => $validated['quantity']]);

        return back()->with('status', 'Cart updated.');
    }

    // Remove one item from the cart
    public function remove($itemId)
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $itemId)->delete();

        return back()->with('status', 'Item removed from cart.');
    }
}