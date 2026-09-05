@extends('layouts.app')

@section('title', 'Repair Booked')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    <h2 class="font-display mt-3 mb-2">Repair Request Received</h2>
                    <p class="text-secondary mb-4">
                        Save this tracking ID — you'll need it to check your repair status.
                    </p>

                    <div class="ticket-card mx-auto" style="margin-left: auto; margin-right: auto;">
                        <div class="ticket-id fs-5">{{ $repair->tracking_id }}</div>
                        <span class="ticket-status">{{ ucfirst($repair->status) }}</span>

                        <div class="ticket-row">
                            <span>Device</span>
                            <span>{{ $repair->device_brand }} {{ $repair->device_model }}</span>
                        </div>
                        <div class="ticket-row">
                            <span>Issue</span>
                            <span>{{ $repair->issue }}</span>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" class="btn btn-outline-soft mt-4">Back to Home</a>
                </div>
            </div>
        </div>
    </section>
@endsection