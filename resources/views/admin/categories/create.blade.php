@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Add Category</h4>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-soft btn-sm">Back to Categories</a>
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
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <button type="submit" class="btn btn-accent w-100">Add Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection