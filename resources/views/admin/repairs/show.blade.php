@extends('layouts.admin')

@section('title', 'Repair Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">{{ $repair->tracking_id }}</h4>
        <a href="{{ route('admin.repairs.index') }}" class="btn btn-outline-soft btn-sm">Back to Repairs</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            <div class="service-card mb-4">
                <h5 class="mb-3">Repair Details</h5>
                                <div class="ticket-row"><span>Customer</span><span>{{ $repair->customer_name ?? $repair->user->name }}</span></div>
                <div class="ticket-row"><span>Phone</span><span>{{ $repair->customer_phone ?? $repair->user->phone ?? '—' }}</span></div>
                @if ($repair->delivery_method)
                    <div class="ticket-row"><span>Delivery</span><span>{{ $repair->deliveryMethodLabel() }}</span></div>
                @endif
                <div class="ticket-row"><span>Device</span><span>{{ $repair->device_brand }} {{ $repair->device_model }}</span></div>
                                <div class="ticket-row"><span>Issue</span><span>{{ $repair->issue }}</span></div>
                @if ($repair->device_photo)
                    <div class="mt-2 mb-2">
                        <span class="text-secondary small d-block mb-1">Device Photo (submitted by customer)</span>
                        <img src="{{ asset('storage/' . $repair->device_photo) }}" alt="Device photo" class="img-fluid rounded" style="max-height: 220px;">
                    </div>
                @endif
                <div class="ticket-row">
                    <span>Technician</span>
                    <span>{{ $repair->technician->name ?? 'Not assigned' }}</span>
                </div>

                @if ($repair->status === 'completed' && $repair->user->phone)
                    @php
                        $customerMessage = "Hi {$repair->user->name}, your repair (Tracking ID: {$repair->tracking_id}) is completed and ready for pickup at Al Huda Mobiles Repairing Lab.";
                        $customerWhatsapp = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $repair->user->phone) . '?text=' . urlencode($customerMessage);
                    @endphp
                    <div class="ticket-row">
                        <span>Notify Customer</span>
                        <span>
                            <a href="{{ $customerWhatsapp }}" target="_blank" class="btn btn-accent btn-sm">
                                <i class="bi bi-whatsapp"></i> Send WhatsApp
                            </a>
                        </span>
                    </div>
                @endif

                @if ($repair->needsApproval())
                    <div class="ticket-row">
                        <span>Customer Approval</span>
                        <span>
                            @if ($repair->isApproved())
                                <span class="ticket-status">Approved ({{ $repair->approved_at->format('d M, h:i A') }})</span>
                            @else
                                <span class="badge bg-secondary">Awaiting Approval</span>
                            @endif
                        </span>
                    </div>
                    @unless ($repair->isApproved())
                        <div class="ticket-row">
                            <span>Approval Email</span>
                            <span>
                                {{ $repair->approval_email }}
                                <form method="POST" action="{{ route('admin.repairs.resend-otp', $repair) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-soft btn-sm ms-2">Resend Code</button>
                                </form>
                            </span>
                        </div>
                    @endunless
                @endif
            </div>

            <div class="service-card">
                <h5 class="mb-3">Update Repair</h5>
                <form method="POST" action="{{ route('admin.repairs.update-status', $repair) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected($repair->status === $status)>
                                    {{ ucfirst(str_replace('-', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Technician</label>
                        <select name="technician_id" class="form-select">
                            <option value="">— Not Assigned —</option>
                            @foreach ($technicians as $technician)
                                <option value="{{ $technician->id }}" @selected($repair->technician_id === $technician->id)>
                                    {{ $technician->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Diagnosis</label>
                        <textarea name="diagnosis" class="form-control" rows="3">{{ $repair->diagnosis }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Estimated Cost</label>
                            <input type="number" step="0.01" name="estimated_cost" class="form-control" value="{{ $repair->estimated_cost }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Final Cost</label>
                            <input type="number" step="0.01" name="final_cost" class="form-control" value="{{ $repair->final_cost }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note (optional, added to timeline)</label>
                        <input type="text" name="note" class="form-control" placeholder="e.g. Waiting for replacement screen">
                    </div>

                    <button type="submit" class="btn btn-accent">Save Changes</button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="service-card mb-4">
                <h5 class="mb-3">Status Timeline</h5>
                @forelse ($repair->statusHistories->sortByDesc('created_at') as $history)
                    <div class="ticket-row">
                        <span>{{ ucfirst(str_replace('-', ' ', $history->new_status)) }}</span>
                        <span>{{ $history->created_at->format('d M, h:i A') }}</span>
                    </div>
                @empty
                    <p class="text-secondary mb-0">No updates yet.</p>
                @endforelse
            </div>

            @if ($repair->delivery)
                <div class="service-card">
                    <h5 class="mb-3">Delivery Confirmation</h5>
                    <p class="text-secondary small mb-2">
                        Confirmed by customer on {{ $repair->delivery->created_at->format('d M Y, h:i A') }}
                    </p>
                    <img src="{{ asset('storage/' . $repair->delivery->photo) }}" alt="Delivery photo" class="img-fluid rounded">
                </div>
            @endif
        </div>

    </div>
@endsection