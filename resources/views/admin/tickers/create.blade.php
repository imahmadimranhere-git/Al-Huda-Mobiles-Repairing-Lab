@extends('layouts.admin')

@section('title', 'Add Announcement')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Add Announcement</h4>
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
                <form method="POST" action="{{ route('admin.tickers.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Text</label>
                        <input type="text" name="text" class="form-control" value="{{ old('text') }}"
                               placeholder="e.g. 50% OFF on all screen replacements this week!" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link (optional)</label>
                        <input type="text" name="url" class="form-control" value="{{ old('url') }}" placeholder="/shop">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="{{ old('display_order', 0) }}" min="0">
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Add Announcement</button>
                </form>
            </div>
        </div>
    </div>
@endsection