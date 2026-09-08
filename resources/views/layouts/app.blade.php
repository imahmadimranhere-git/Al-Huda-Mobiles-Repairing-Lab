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

    <nav class="navbar navbar-expand-lg site-navbar">
        <div class="container">
            <a class="navbar-brand brand" href="{{ route('home') }}">
                <i class="bi bi-cpu"></i> Al Huda Mobiles Repairing Lab
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('repairs.track') }}">Track Repair</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('repairs.create') }}">Book Repair</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-soft btn-sm" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="btn btn-outline-soft btn-sm" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="btn btn-accent btn-sm" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

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
        // Auto-dismiss any success/error alert after 3 seconds, with a short fade-out.
        document.querySelectorAll('.alert').forEach(function (alertBox) {
            setTimeout(function () {
                alertBox.style.transition = 'opacity 0.4s ease';
                alertBox.style.opacity = '0';
                setTimeout(function () {
                    alertBox.remove();
                }, 400);
            }, 3000);
        });
    </script>
</body>
</html>