@extends('layouts.admin')

@section('title', 'Edit Technician')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Edit Technician</h4>
        <a href="{{ route('admin.technicians.index') }}" class="btn btn-outline-soft btn-sm">Back to Technicians</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="service-card">
                <form method="POST" action="{{ route('admin.technicians.update', $technician) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $technician->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $technician->email) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $technician->phone) }}">
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection