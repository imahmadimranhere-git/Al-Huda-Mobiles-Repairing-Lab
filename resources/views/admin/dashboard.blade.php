@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h4 class="mb-4 font-display">Welcome, {{ auth()->user()->name }}</h4>

    {{-- Placeholder stat cards for Phase 1. Real counts (customers, repairs,
         orders, revenue) will be wired up in Phase 2. --}}
    <div class="row g-3">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-people"></i></div>
                <div class="stat-label">Total Customers</div>
                <div class="stat-value">—</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-tools"></i></div>
                <div class="stat-label">Active Repairs</div>
                <div class="stat-value">—</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-cart"></i></div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value">—</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-cash-stack"></i></div>
                <div class="stat-label">Total Sales</div>
                <div class="stat-value">—</div>
            </div>
        </div>
    </div>
@endsection