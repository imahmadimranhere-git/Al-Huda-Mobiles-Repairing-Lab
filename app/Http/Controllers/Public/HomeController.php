<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AnnouncementTicker;
use App\Models\Banner;
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
            'hero_video_url' => SiteSetting::get('hero_video_url'),
        ];

        // Show only the first 3 on the home page — "See More" links to the
        // full services page only when there are more than 3 to show.
        $services = Service::where('is_active', true)->orderBy('display_order')->take(3)->get();
        $servicesCount = Service::where('is_active', true)->count();

        $newsItems = NewsUpdate::where('is_active', true)
            ->orderBy('display_order')
            ->orderByDesc('published_date')
            ->take(3)
            ->get();

        $shopCategories = Category::where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)->latest()->take(5);
            }])
            ->get()
            ->filter(fn ($category) => $category->products->isNotEmpty());

        $tickers = AnnouncementTicker::where('is_active', true)->orderBy('display_order')->get();
        $banners = Banner::where('is_active', true)->orderBy('display_order')->get();

        return view('home', [
            'settings' => $settings,
            'services' => $services,
            'servicesCount' => $servicesCount,
            'newsItems' => $newsItems,
            'shopCategories' => $shopCategories,
            'tickers' => $tickers,
            'banners' => $banners,
        ]);
    }
}