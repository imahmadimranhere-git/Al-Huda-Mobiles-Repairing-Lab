<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al Huda Mobiles Repairing Lab')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
</head>
<body>

    @php
        $siteLogo = \App\Models\SiteSetting::get('site_logo');
        $cartCount = auth()->check()
            ? (\App\Models\Cart::where('user_id', auth()->id())->first()?->items()->sum('quantity') ?? 0)
            : 0;
    @endphp

    <header class="site-navbar">
        <div class="nav-inner">
            {{-- Logo — left, untouched, own proportions preserved --}}
            <a href="{{ route('home') }}" class="nav-logo">
                @if ($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="Al Huda Mobiles Repairing Lab">
                @else
                    <span class="nav-logo-fallback"><i class="bi bi-cpu"></i> Al Huda Mobiles Repairing Lab</span>
                @endif
            </a>

            {{-- Center nav links (desktop) --}}
            <nav class="nav-links d-none d-lg-flex">
                <a href="{{ route('home') }}" class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('shop.index') }}" class="nav-link-item {{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a>
                <a href="{{ route('repairs.track') }}" class="nav-link-item {{ request()->routeIs('repairs.track*') ? 'active' : '' }}">Track Repair</a>
                <a href="{{ route('repairs.create') }}" class="nav-link-item {{ request()->routeIs('repairs.create') ? 'active' : '' }}">Book Repair</a>
                <a href="{{ route('orders.index') }}" class="nav-link-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">My Orders</a>
                <a href="{{ route('news.index') }}" class="nav-link-item {{ request()->routeIs('news.*') ? 'active' : '' }}">News &amp; Updates</a>
            </nav>

            {{-- Right icons + mobile toggle --}}
            <div class="nav-actions">
                <div class="dropdown">
                    <button class="nav-icon-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Account">
                        <i class="bi bi-person"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @auth
                            @unless (auth()->user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}">My Repairs</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endunless
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        @endauth
                    </ul>
                </div>

                <a href="{{ route('cart.index') }}" class="nav-icon-btn position-relative" aria-label="Cart">
                    <i class="bi bi-cart3"></i>
                    @if ($cartCount > 0)
                        <span class="cart-count-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                <button class="nav-hamburger d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav" aria-label="Menu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        {{-- Mobile menu panel --}}
        <div class="collapse d-lg-none" id="mobileNav">
            <nav class="nav-links-mobile">
                <a href="{{ route('home') }}" class="nav-link-item {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('shop.index') }}" class="nav-link-item {{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a>
                <a href="{{ route('repairs.track') }}" class="nav-link-item {{ request()->routeIs('repairs.track*') ? 'active' : '' }}">Track Repair</a>
                <a href="{{ route('repairs.create') }}" class="nav-link-item {{ request()->routeIs('repairs.create') ? 'active' : '' }}">Book Repair</a>
                <a href="{{ route('orders.index') }}" class="nav-link-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">My Orders</a>
                <a href="{{ route('news.index') }}" class="nav-link-item {{ request()->routeIs('news.*') ? 'active' : '' }}">News &amp; Updates</a>
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

    @php
        $footerPhone = \App\Models\SiteSetting::get('contact_phone');
        $footerWhatsapp = \App\Models\SiteSetting::get('contact_whatsapp');
        $footerEmail = \App\Models\SiteSetting::get('contact_email');
        $footerAddress = \App\Models\SiteSetting::get('contact_address');
    @endphp

    <footer class="site-footer">
        <div class="container">
            @if ($footerPhone || $footerWhatsapp || $footerEmail || $footerAddress)
                <div class="row g-3 mb-3 text-center text-md-start">
                    @if ($footerPhone)
                        <div class="col-md-3"><i class="bi bi-telephone me-1"></i> {{ $footerPhone }}</div>
                    @endif
                    @if ($footerWhatsapp)
                        <div class="col-md-3"><i class="bi bi-whatsapp me-1"></i> {{ $footerWhatsapp }}</div>
                    @endif
                    @if ($footerEmail)
                        <div class="col-md-3"><i class="bi bi-envelope me-1"></i> {{ $footerEmail }}</div>
                    @endif
                    @if ($footerAddress)
                        <div class="col-md-3"><i class="bi bi-geo-alt me-1"></i> {{ $footerAddress }}</div>
                    @endif
                </div>
                <hr style="border-color: var(--color-border);">
            @endif
            <p class="mb-0 text-center">&copy; {{ date('Y') }} Al Huda Mobiles Repairing Lab. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.alert').forEach(function (alertBox) {
            setTimeout(function () {
                alertBox.style.transition = 'opacity 0.4s ease';
                alertBox.style.opacity = '0';
                setTimeout(function () { alertBox.remove(); }, 400);
            }, 3000);
        });
    </script>
</body>
</html>