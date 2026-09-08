@extends('layouts.admin')

@section('title', 'Edit News')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Edit News</h4>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-soft btn-sm">Back to News</a>
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
                <form method="POST" action="{{ route('admin.news.update', $news) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="4">{{ old('content', $news->content) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $news->published_date?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Display Order</label>
                            <input type="number" name="display_order" class="form-control" value="{{ old('display_order', $news->display_order) }}" min="0">
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                               @checked(old('is_active', $news->is_active))>
                        <label class="form-check-label" for="isActive">Active (visible on home page)</label>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection