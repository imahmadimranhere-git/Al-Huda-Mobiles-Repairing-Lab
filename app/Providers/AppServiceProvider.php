<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Use Bootstrap-styled pagination links instead of the default
        // Tailwind ones, which render as oversized unstyled SVG icons
        // when Tailwind CSS isn't loaded.
        Paginator::useBootstrapFive();
    }
}