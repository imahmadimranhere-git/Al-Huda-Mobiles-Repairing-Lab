@extends('layouts.admin')

@section('title', 'Edit Announcement')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Edit Announcement</h4>
        <a href="{{ route('admin.tickers.index') }}" class="btn btn-outline-soft btn-sm">Back</a>
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
                <form method="POST" action="{{ route('admin.tickers.update', $ticker) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Text</label>
                        <input type="text" name="text" class="form-control" value="{{ old('text', $ticker->text) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link (optional)</label>
                        <input type="text" name="url" class="form-control" value="{{ old('url', $ticker->url) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="{{ old('display_order', $ticker->display_order) }}" min="0">
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                               @checked(old('is_active', $ticker->is_active))>
                        <label class="form-check-label" for="isActive">Active</label>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection