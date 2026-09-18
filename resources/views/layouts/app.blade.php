<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al Huda Mobiles Repairing Lab')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>
<body>

    @php
        $siteLogo = \App\Models\SiteSetting::get('site_logo');
        $siteName = \App\Models\SiteSetting::get('site_name', 'Al Huda Mobiles Repairing Lab');

        $cartCount = auth()->check()
            ? (\App\Models\Cart::where('user_id', auth()->id())->first()?->items()->sum('quantity') ?? 0)
            : 0;
    @endphp

    {{-- ============ NAVBAR ============ --}}
    <header class="site-navbar">
        <div class="nav-inner">

            <div class="nav-top-row">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="nav-logo">
                    @if ($siteLogo)
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}">
                    @else
                        <span class="nav-logo-fallback">
                            <i class="bi bi-cpu"></i> {{ $siteName }}
                        </span>
                    @endif
                </a>

                {{-- Desktop Nav Links --}}
                <nav class="nav-links d-none d-xl-flex">
                    <a href="{{ route('home') }}" class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                    <a href="{{ route('shop.index') }}" class="nav-link-item {{ request()->routeIs('shop.*') ? 'active' : '' }}">
                        <i class="bi bi-bag"></i> Shop
                    </a>
                    <a href="{{ route('home') }}#services" class="nav-link-item">
                        <i class="bi bi-tools"></i> Our Services
                    </a>
                    <a href="{{ route('news.index') }}" class="nav-link-item {{ request()->routeIs('news.*') ? 'active' : '' }}">
                        <i class="bi bi-newspaper"></i> News
                    </a>
                </nav>

                {{-- Action Buttons --}}
                <div class="nav-action-buttons d-none d-xl-flex">
                    <a href="{{ route('repairs.create') }}" class="btn-nav-primary">
                        <i class="bi bi-wrench-adjustable"></i> Book a Repair
                    </a>
                    <a href="{{ route('repairs.track') }}" class="btn-nav-outline">
                        <i class="bi bi-search-heart"></i> Track
                    </a>
                </div>

                {{-- Right Icons --}}
                <div class="nav-actions">
                    <a href="{{ route('cart.index') }}" class="nav-icon-btn position-relative" aria-label="Cart">
                        <i class="bi bi-cart3"></i>
                        @if ($cartCount > 0)
                            <span class="cart-count-badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <div class="dropdown">
                        <button class="nav-icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Account">
                            <i class="bi bi-person"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @auth
                                @unless (auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>My Repairs</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-bag me-2"></i>My Orders</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endunless
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            @else
                                <li><a class="dropdown-item" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}"><i class="bi bi-person-plus me-2"></i>Register</a></li>
                            @endauth
                        </ul>
                    </div>

                    <button class="nav-hamburger d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav" aria-label="Menu">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>

            {{-- Search Row --}}
            <div class="nav-search-row">
                <form action="{{ route('shop.index') }}" method="GET" class="nav-search-form">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" placeholder="Search products, repairs…" value="{{ request('q') }}">
                    <button type="submit" aria-label="Search">
                        <span class="d-none d-sm-inline">Search</span>
                        <i class="bi bi-arrow-right d-sm-none"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="collapse d-xl-none" id="mobileNav">
            <nav class="nav-links-mobile">

                <a href="{{ route('home') }}" class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Home
                </a>
                <a href="{{ route('shop.index') }}" class="nav-link-item {{ request()->routeIs('shop.*') ? 'active' : '' }}">
                    <i class="bi bi-bag"></i> Shop
                </a>
                <a href="{{ route('home') }}#services" class="nav-link-item">
                    <i class="bi bi-tools"></i> Our Services
                </a>
                <a href="{{ route('news.index') }}" class="nav-link-item {{ request()->routeIs('news.*') ? 'active' : '' }}">
                    <i class="bi bi-newspaper"></i> News &amp; Updates
                </a>
                <a href="{{ route('orders.index') }}" class="nav-link-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> My Orders
                </a>

                <div class="mobile-cta-group">
                    <a href="{{ route('repairs.create') }}" class="btn btn-accent w-100">
                        <i class="bi bi-wrench-adjustable"></i> Book a Repair
                    </a>
                    <a href="{{ route('repairs.track') }}" class="btn btn-outline-soft w-100">
                        <i class="bi bi-search-heart"></i> Track My Repair
                    </a>
                </div>
            </nav>
        </div>
    </header>

    @include('partials.announcement-ticker', ['tickers' => $tickers ?? collect()])

    @if (session('status'))
        <div class="container mt-3">
            <div class="alert alert-success">{{ session('status') }}</div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.alert').forEach(function (alertBox) {
            setTimeout(function () {
                alertBox.style.transition = 'opacity 0.4s ease';
                alertBox.style.opacity = '0';
                setTimeout(function () { alertBox.remove(); }, 400);
            }, 3000);
        });

        const navbar = document.querySelector('.site-navbar');
        if (navbar) {
            window.addEventListener('scroll', function () {
                navbar.classList.toggle('scrolled', window.scrollY > 10);
            }, { passive: true });
        }

        document.querySelectorAll('#mobileNav .nav-link-item').forEach(function (link) {
            link.addEventListener('click', function () {
                const el = document.getElementById('mobileNav');
                if (el && el.classList.contains('show')) {
                    bootstrap.Collapse.getOrCreateInstance(el).hide();
                }
            });
        });
    </script>
</body>
</html>