@extends('layouts.admin')

@section('title', 'Walk-In Repair')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">New Walk-In Repair</h4>
        <a href="{{ route('admin.repairs.index') }}" class="btn btn-outline-soft btn-sm">Back to Repairs</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="service-card">
                <form method="POST" action="{{ route('admin.repairs.walk-in.store') }}">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Device Brand</label>
                            <input type="text" name="device_brand" class="form-control" value="{{ old('device_brand') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Device Model</label>
                            <input type="text" name="device_model" class="form-control" value="{{ old('device_model') }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Issue</label>
                        <textarea name="issue" class="form-control" rows="3" required>{{ old('issue') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Create Repair</button>
                </form>
            </div>
        </div>
    </div>
@endsection