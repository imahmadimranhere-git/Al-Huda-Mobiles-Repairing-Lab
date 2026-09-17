@extends('layouts.admin')

@section('title', 'Add Banner')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Add Banner</h4>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-soft btn-sm">Back</a>
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
                <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Title (optional, for your reference)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Desktop Image <span class="text-danger">*</span></label>
                        <input type="file" name="image_desktop" class="form-control" accept="image/*" required>
                        <div class="form-text">Recommended: 1600×500px (wide banner)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tablet Image <span class="text-danger">*</span></label>
                        <input type="file" name="image_tablet" class="form-control" accept="image/*" required>
                        <div class="form-text">Recommended: 1000×500px</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mobile Image <span class="text-danger">*</span></label>
                        <input type="file" name="image_mobile" class="form-control" accept="image/*" required>
                        <div class="form-text">Recommended: 600×600px (taller, mobile-friendly)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link (optional)</label>
                        <input type="text" name="url" class="form-control" value="{{ old('url') }}" placeholder="/shop">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="{{ old('display_order', 0) }}" min="0">
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Add Banner</button>
                </form>
            </div>
        </div>
    </div>
@endsection