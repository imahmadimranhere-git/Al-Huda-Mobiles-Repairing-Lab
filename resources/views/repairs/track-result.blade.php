@extends('layouts.app')

@section('title', 'Repair Status')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                            @if (session('whatsapp_url'))
                                <br>
                                <a href="{{ session('whatsapp_url') }}" target="_blank" class="btn btn-accent btn-sm mt-2">
                                    <i class="bi bi-whatsapp"></i> Notify Us on WhatsApp
                                </a>
                            @endif
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="ticket-card mb-4" style="margin-left: auto; margin-right: auto; max-width: 100%;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="ticket-id fs-5">{{ $repair->tracking_id }}</div>
                                <span class="ticket-status">{{ ucfirst(str_replace('-', ' ', $repair->status)) }}</span>
                            </div>
                            <div class="text-center">
                                {!! $qrCode !!}
                                <p class="text-secondary small mb-0">Scan to track</p>
                            </div>
                        </div>

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
                        <div class="ticket-row">
                            <span>Customer Name</span>
                            <span>{{ $repair->customer_name ?? $repair->user->name }}</span>
                        </div>
                        <div class="ticket-row">
                            <span>Customer Phone</span>
                            <span>{{ $repair->customer_phone ?? $repair->user->phone ?? '—' }}</span>
                        </div>
                        <div class="ticket-row">
                            <span>Technician</span>
                            <span>{{ $repair->technician->name ?? 'Not assigned yet' }}</span>
                        </div>
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
                    </div>

                    <h5 class="font-display mb-3">Status Timeline</h5>
                    <div class="service-card mb-4">
                        @forelse ($repair->statusHistories->sortByDesc('created_at') as $history)
                            <div class="ticket-row">
                                <span>{{ ucfirst(str_replace('-', ' ', $history->new_status)) }}</span>
                                <span>{{ $history->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        @empty
                            <p class="text-secondary mb-0">No status updates yet.</p>
                        @endforelse
                    </div>

                    @if (in_array($repair->status, ['ready-for-pickup', 'completed']))
                        @if ($repair->delivery)
                            <div class="service-card">
                                <h5 class="mb-2"><i class="bi bi-check-circle text-success"></i> Device Receipt Confirmed</h5>
                                <p class="text-secondary mb-0">You confirmed receiving this device on {{ $repair->delivery->created_at->format('d M Y, h:i A') }}.</p>
                            </div>
                        @else
                            <div class="service-card">
                                <h5 class="mb-3">Confirm Device Received</h5>
                                <p class="text-secondary small mb-3">Upload a photo of your device to confirm you've received it back.</p>

                                <form method="POST" action="{{ route('repairs.confirm-delivery', $repair->tracking_id) }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Upload a photo of your received device</label>
                                        <input type="file" name="photo" class="form-control" accept="image/*" required>
                                    </div>

                                    <button type="submit" class="btn btn-accent w-100">Confirm Received</button>
                                </form>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection