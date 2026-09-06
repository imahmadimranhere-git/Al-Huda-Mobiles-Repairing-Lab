@extends('layouts.app')

@section('title', 'Repair Status')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    <div class="ticket-card mb-4" style="margin-left: auto; margin-right: auto; max-width: 100%;">
                        <div class="ticket-id fs-5">{{ $repair->tracking_id }}</div>
                        <span class="ticket-status">{{ ucfirst(str_replace('-', ' ', $repair->status)) }}</span>

                        <div class="ticket-row">
                            <span>Device</span>
                            <span>{{ $repair->device_brand }} {{ $repair->device_model }}</span>
                        </div>
                        <div class="ticket-row">
                            <span>Issue</span>
                            <span>{{ $repair->issue }}</span>
                        </div>
                        @if ($repair->diagnosis)
                            <div class="ticket-row">
                                <span>Diagnosis</span>
                                <span>{{ $repair->diagnosis }}</span>
                            </div>
                        @endif
                    </div>

                    <h5 class="font-display mb-3">Status Timeline</h5>
                    <div class="service-card">
                        @forelse ($repair->statusHistories->sortByDesc('created_at') as $history)
                            <div class="ticket-row">
                                <span>{{ ucfirst(str_replace('-', ' ', $history->new_status)) }}</span>
                                <span>{{ $history->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        @empty
                            <p class="text-secondary mb-0">No status updates yet.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection