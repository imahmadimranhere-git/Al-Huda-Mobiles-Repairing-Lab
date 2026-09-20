<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsUpdate;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    // Site-wide search: looks across Products, Services and News together
    // instead of being limited to just the Shop.
    public function index(Request $request): View
    {
        $query = trim((string) $request->get('q'));

        $products = collect();
        $services = collect();
        $newsItems = collect();

        if ($query !== '') {
            $products = Product::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->take(12)
                ->get();

            $services = Service::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->take(12)
                ->get();

            $newsItems = NewsUpdate::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->take(12)
                ->get();
        }

        return view('search.index', [
            'query' => $query,
            'products' => $products,
            'services' => $services,
            'newsItems' => $newsItems,
        ]);
    }
}