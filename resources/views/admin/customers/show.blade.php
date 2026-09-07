@extends('layouts.admin')

@section('title', 'Customer Profile')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">{{ $customer->name }}</h4>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-soft btn-sm">Back to Customers</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="service-card">
                <h5 class="mb-3">Profile</h5>
                <div class="ticket-row"><span>Email</span><span>{{ $customer->email ?? '—' }}</span></div>
                <div class="ticket-row"><span>Phone</span><span>{{ $customer->phone ?? '—' }}</span></div>
                <div class="ticket-row"><span>Joined</span><span>{{ $customer->created_at->format('d M Y') }}</span></div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="service-card">
                <h5 class="mb-3">Repair History</h5>
                @forelse ($customer->repairs as $repair)
                    <div class="ticket-row">
                        <span>
                            <a href="{{ route('admin.repairs.show', $repair) }}">{{ $repair->tracking_id }}</a>
                            — {{ $repair->device_brand }} {{ $repair->device_model }}
                        </span>
                        <span>{{ ucfirst(str_replace('-', ' ', $repair->status)) }}</span>
                    </div>
                @empty
                    <p class="text-secondary mb-0">No repairs booked yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection