<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // List all active products, with category filter and search
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('shop.index', ['products' => $products, 'categories' => $categories]);
    }

    // Show a single product's details
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        return view('shop.show', ['product' => $product]);
    }
}