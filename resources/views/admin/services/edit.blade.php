@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Edit Service</h4>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-soft btn-sm">Back to Services</a>
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
                @if ($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                         class="img-fluid rounded mb-3" style="max-height: 180px; object-fit: cover;">
                @endif

                <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Card Image {{ $service->image ? '(leave blank to keep current)' : '' }}</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="{{ old('display_order', $service->display_order) }}" min="0">
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                               @checked(old('is_active', $service->is_active))>
                        <label class="form-check-label" for="isActive">Active (visible on home page)</label>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection