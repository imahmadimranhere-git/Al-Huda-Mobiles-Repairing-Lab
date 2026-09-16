@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Reports</h4>
        <a href="{{ route('admin.reports.pdf', request()->query()) }}" class="btn btn-accent">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF
        </a>
    </div>

    <div class="service-card mb-4">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">From</label>
                <input type="date" name="from" class="form-control" value="{{ $from->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">To</label>
                <input type="date" name="to" class="form-control" value="{{ $to->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-soft w-100">Apply Range</button>
            </div>
        </form>
    </div>

    {{-- Top-level totals --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-cash-stack"></i></div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">Rs. {{ number_format($totalRevenue, 0) }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-tools"></i></div>
                <div class="stat-label">Total Repairs</div>
                <div class="stat-value">{{ $totalRepairs }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-cart"></i></div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ $totalOrders }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-people"></i></div>
                <div class="stat-label">New Customers</div>
                <div class="stat-value">{{ $newCustomers }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Repairs report --}}
        <div class="col-lg-6">
            <div class="service-card">
                <h5 class="mb-3">Repairs</h5>
                <div class="ticket-row"><span>Total Repairs</span><span>{{ $totalRepairs }}</span></div>
                <div class="ticket-row"><span>Completed</span><span>{{ $completedRepairs }}</span></div>
                <div class="ticket-row"><span>Revenue from Repairs</span><span>Rs. {{ number_format($repairRevenue, 2) }}</span></div>

                <h6 class="mt-3 mb-2 text-secondary small text-uppercase">By Status</h6>
                @forelse ($repairsByStatus as $status => $count)
                    <div class="ticket-row">
                        <span>{{ ucfirst(str_replace('-', ' ', $status)) }}</span>
                        <span>{{ $count }}</span>
                    </div>
                @empty
                    <p class="text-secondary small mb-0">No repairs in this range.</p>
                @endforelse
            </div>
        </div>

        {{-- Shop / Orders report --}}
        <div class="col-lg-6">
            <div class="service-card">
                <h5 class="mb-3">Shop</h5>
                <div class="ticket-row"><span>Total Orders</span><span>{{ $totalOrders }}</span></div>
                <div class="ticket-row"><span>Revenue (Completed Orders)</span><span>Rs. {{ number_format($orderRevenue, 2) }}</span></div>

                <h6 class="mt-3 mb-2 text-secondary small text-uppercase">By Status</h6>
                @forelse ($ordersByStatus as $status => $count)
                    <div class="ticket-row">
                        <span>{{ ucfirst($status) }}</span>
                        <span>{{ $count }}</span>
                    </div>
                @empty
                    <p class="text-secondary small mb-0">No orders in this range.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection