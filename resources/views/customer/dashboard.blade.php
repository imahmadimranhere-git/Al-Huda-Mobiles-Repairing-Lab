@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="font-display mb-0">My Repairs</h4>
                <a href="{{ route('repairs.create') }}" class="btn btn-accent">Book New Repair</a>
            </div>

            <div class="row g-4">
                @forelse ($repairs as $repair)
                    <div class="col-md-6">
                        <div class="ticket-card" style="max-width: 100%; margin-left: 0;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="ticket-id">{{ $repair->tracking_id }}</div>
                                <span class="ticket-status">{{ ucfirst(str_replace('-', ' ', $repair->status)) }}</span>
                            </div>
                            <div class="ticket-row">
                                <span>Device</span>
                                <span>{{ $repair->device_brand }} {{ $repair->device_model }}</span>
                            </div>
                            <div class="ticket-row">
                                <span>Issue</span>
                                <span>{{ $repair->issue }}</span>
                            </div>
                            <div class="ticket-row">
                                <span>Booked On</span>
                                <span>{{ $repair->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="service-card text-center">
                            <p class="text-secondary mb-3">You haven't booked any repairs yet.</p>
                            <a href="{{ route('repairs.create') }}" class="btn btn-accent">Book Your First Repair</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection