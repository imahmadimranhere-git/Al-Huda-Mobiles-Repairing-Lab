@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h4 class="mb-4 font-display">Welcome, {{ auth()->user()->name }}</h4>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-people"></i></div>
                <div class="stat-label">Total Customers</div>
                <div class="stat-value">{{ $totalCustomers }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-tools"></i></div>
                <div class="stat-label">Active Repairs</div>
                <div class="stat-value">{{ $activeRepairs }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-cart"></i></div>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value">{{ $pendingOrders }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="icon"><i class="bi bi-cash-stack"></i></div>
                <div class="stat-label">Total Sales</div>
                <div class="stat-value">Rs. {{ number_format($totalSales) }}</div>
            </div>
        </div>
    </div>
@endsection