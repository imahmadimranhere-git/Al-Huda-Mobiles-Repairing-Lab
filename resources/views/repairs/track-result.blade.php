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
                        @if ($repair->technician)
                            <div class="ticket-row">
                                <span>Technician</span>
                                <span>{{ $repair->technician->name }}</span>
                            </div>
                        @endif
                        @if ($repair->estimated_cost)
                            <div class="ticket-row">
                                <span>Estimated Cost</span>
                                <span>Rs. {{ number_format($repair->estimated_cost, 2) }}</span>
                            </div>
                        @endif
                        @if ($repair->final_cost)
                            <div class="ticket-row">
                                <span>Final Cost</span>
                                <span>Rs. {{ number_format($repair->final_cost, 2) }}</span>
                            </div>
                        @endif
                        @if ($repair->customer_approval)
                            <div class="ticket-row">
                                <span>Approval</span>
                                <span>
                                    {{ ucfirst($repair->customer_approval) }}
                                    @if ($repair->approved_at)
                                        ({{ $repair->approved_at->format('d M, h:i A') }})
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>

                    <h5 class="font-display mb-3">Status Timeline</h5>
                    <div class="service-card">
                        @forelse ($repair->statusHistories->sortByDesc('created_at') as $history)
                            <div class="ticket-row">
                                <span>{{ ucfirst(str_replace('-', ' ', $history->new_status)) }}</span>
                                <span>{{ $history->created_at->format('d M Y, h:i A') }}</span>
                                @if ($history->note)
                                    <div class="text-secondary small mt-1">{{ $history->note }}</div>
                                @endif
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