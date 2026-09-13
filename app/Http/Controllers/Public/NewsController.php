<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsUpdate;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $newsItems = NewsUpdate::where('is_active', true)
            ->orderBy('display_order')
            ->orderByDesc('published_date')
            ->paginate(9);

        return view('public.news', ['newsItems' => $newsItems]);
    }
}