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
                <div class="ticket-row"><span>Customer</span><span>{{ $repair->user->name }}</span></div>
                <div class="ticket-row"><span>Device</span><span>{{ $repair->device_brand }} {{ $repair->device_model }}</span></div>
                <div class="ticket-row"><span>Issue</span><span>{{ $repair->issue }}</span></div>
                <div class="ticket-row">
                    <span>Technician</span>
                    <span>{{ $repair->technician->name ?? 'Not assigned' }}</span>
                </div>
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
            <div class="service-card">
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
        </div>
    </div>
@endsection