@extends('layouts.admin')

@section('title', 'Repairs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Repairs</h4>
        <a href="{{ route('admin.repairs.walk-in.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> New Walk-In Repair
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="service-card mb-4">
        <form method="GET" action="{{ route('admin.repairs.index') }}" class="row g-2 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                       placeholder="Tracking ID, brand or model">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst(str_replace('-', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-accent w-100">Filter</button>
            </div>
        </form>
    </div>

    <div class="service-card p-0">
        <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4">Tracking ID</th>
                    <th>Customer</th>
                    <th>Device</th>
                    <th>Technician</th>
                    <th>Status</th>
                    <th>Booked On</th>
                    <th class="pe-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($repairs as $repair)
                    <tr>
                        <td class="ps-4">{{ $repair->tracking_id }}</td>
                        <td>{{ $repair->customer_name ?? $repair->user->name }}<td>
                        <td>{{ $repair->device_brand }} {{ $repair->device_model }}</td>
                        <td>{{ $repair->technician->name ?? '—' }}</td>
                        <td>
                            <span class="ticket-status">{{ ucfirst(str_replace('-', ' ', $repair->status)) }}</span>
                        </td>
                        <td>{{ $repair->created_at->format('d M Y') }}</td>
                                                    <td class="pe-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.repairs.show', $repair) }}" class="btn btn-outline-soft btn-sm">View</a>
                                </div>
                            </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-secondary py-4">No repairs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $repairs->links() }}
    </div>
@endsection