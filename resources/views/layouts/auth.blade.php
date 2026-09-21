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
<body class="auth-body">

    @php $authLogo = \App\Models\SiteSetting::get('site_logo'); @endphp

    <div class="auth-wrap">
        <div class="auth-card">

            <div class="text-center mb-4">
                <a href="{{ route('home') }}">
                    @if ($authLogo)
                        <img src="{{ asset('storage/' . $authLogo) }}" alt="Al Huda Mobiles Repairing Lab" class="auth-logo">
                    @else
                        <span class="auth-logo-fallback"><i class="bi bi-cpu"></i> Al Huda Mobiles Repairing Lab</span>
                    @endif
                </a>
            </div>

            @yield('content')

        </div>

        <p class="auth-back-link">
            <a href="{{ route('home') }}"><i class="bi bi-arrow-left"></i> Back to Home</a>
        </p>
    </div>

</body>
</html>