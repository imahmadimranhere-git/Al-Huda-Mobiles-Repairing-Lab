@extends('layouts.admin')

@section('title', 'Add Service')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Add Service</h4>
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
                <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Card Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Recommended: a landscape photo, at least 600×400px.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="{{ old('display_order', 0) }}" min="0">
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Add Service</button>
                </form>
            </div>
        </div>
    </div>
@endsection