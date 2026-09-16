<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — Al Huda Mobiles Repairing Lab</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
</head>
<body>

<div class="admin-shell">

    {{-- Sidebar: fixed on every screen size. On tablet/mobile it's off-canvas
         and slides in via the .is-open class (toggled by JS below). --}}
    <aside class="admin-sidebar" id="adminSidebar">
                <div class="admin-sidebar-brand">
            @php
                $sidebarLogo = \App\Models\SiteSetting::get('site_logo');
            @endphp
            @if ($sidebarLogo)
                <img src="{{ asset('storage/' . $sidebarLogo) }}" alt="Logo" style="height: 32px; object-fit: contain;">
            @else
                <h5 class="mb-0 font-display"><i class="bi bi-cpu"></i> Al Huda Mobiles Repairing Lab</h5>
            @endif
        </div>

        <nav class="admin-sidebar-nav">
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                       href="{{ route('admin.customers.index') }}">
                        <i class="bi bi-people"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.repairs.*') ? 'active' : '' }}"
                       href="{{ route('admin.repairs.index') }}">
                        <i class="bi bi-tools"></i> Repairs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.technicians.*') ? 'active' : '' }}"
                       href="{{ route('admin.technicians.index') }}">
                        <i class="bi bi-person-gear"></i> Technicians
                    </a>
                </li>
                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}"
                       href="{{ route('admin.services.index') }}">
                        <i class="bi bi-grid-3x3-gap"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}"
                       href="{{ route('admin.news.index') }}">
                        <i class="bi bi-newspaper"></i> News & Updates
                    </a>
                </li>
                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.website.*') ? 'active' : '' }}"
                       href="{{ route('admin.website.home') }}">
                        <i class="bi bi-layout-text-window"></i> Website Content
                    </a>
                </li>

                                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                       href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tags"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                       href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam"></i> Products
                    </a>
                </li>

                                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                       href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-receipt"></i> Orders
                    </a>
                </li>

                                <li class="nav-item">
                    <a class="admin-nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                       href="{{ route('admin.reports.index') }}">
                        <i class="bi bi-graph-up"></i> Reports
                    </a>
                </li>
                
            </ul>
        </nav>

        {{-- User name + Logout, pinned to the bottom of the sidebar --}}
        <div class="admin-sidebar-footer">
            <div class="user-name">{{ auth()->user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-soft btn-sm w-100" type="submit">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-backdrop" id="adminBackdrop"></div>

    {{-- Main content: margin-left makes room for the fixed sidebar on desktop --}}
    <div class="admin-main">
        <nav class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-soft btn-sm d-lg-none" id="sidebarToggle" type="button">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-semibold">@yield('title', 'Dashboard')</span>
            </div>
        </nav>

        <div class="admin-content">
            @yield('content')
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('adminSidebar');
    const backdrop = document.getElementById('adminBackdrop');
    const toggleBtn = document.getElementById('sidebarToggle');

    function openSidebar() {
        sidebar.classList.add('is-open');
        backdrop.classList.add('is-visible');
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        backdrop.classList.remove('is-visible');
    }

    toggleBtn.addEventListener('click', openSidebar);
    backdrop.addEventListener('click', closeSidebar);

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