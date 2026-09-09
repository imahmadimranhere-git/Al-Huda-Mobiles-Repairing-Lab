<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NewsUpdate;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $settings = [
            'hero_eyebrow' => SiteSetting::get('hero_eyebrow', 'Precision mobile diagnostics'),
            'hero_heading' => SiteSetting::get('hero_heading', "We fix what your phone can't tell you is wrong."),
            'hero_description' => SiteSetting::get('hero_description', ''),
            'hero_button_text' => SiteSetting::get('hero_button_text', 'Book a repair'),
            'hero_button_url' => SiteSetting::get('hero_button_url', '/book-repair'),
        ];

        $services = Service::where('is_active', true)->orderBy('display_order')->get();

        $newsItems = NewsUpdate::where('is_active', true)
            ->orderBy('display_order')
            ->orderByDesc('published_date')
            ->take(3)
            ->get();

        // For each active category, pull its 5 most recent active products.
        // Categories with no active products are skipped so the home page
        // never shows an empty section.
        $shopCategories = Category::where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)->latest()->take(5);
            }])
            ->get()
            ->filter(fn ($category) => $category->products->isNotEmpty());

        return view('home', [
            'settings' => $settings,
            'services' => $services,
            'newsItems' => $newsItems,
            'shopCategories' => $shopCategories,
        ]);
    }
}