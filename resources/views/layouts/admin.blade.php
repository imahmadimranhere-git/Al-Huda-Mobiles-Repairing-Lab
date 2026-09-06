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

<div class="d-flex admin-shell">

    <aside class="admin-sidebar" id="adminSidebar">
        <h5 class="mb-4 font-display"><i class="bi bi-cpu"></i> Al Huda Mobiles Repairing Lab</h5>

        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
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
            {{-- Products, Orders, Appointments links will be added in later phases --}}
        </ul>
    </aside>

    <div class="admin-backdrop" id="adminBackdrop"></div>

    <div class="flex-grow-1 admin-main">
        <nav class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-soft btn-sm d-lg-none" id="sidebarToggle" type="button">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-semibold">@yield('title', 'Dashboard')</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-sm-inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-soft btn-sm" type="submit">Logout</button>
                </form>
            </div>
        </nav>

        <div class="p-4">
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
</script>

</body>
</html>