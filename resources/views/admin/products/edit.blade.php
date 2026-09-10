@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Edit Product</h4>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-soft btn-sm">Back to Products</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="service-card mb-4">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                         class="img-fluid rounded mb-3" style="max-height: 180px; object-fit: cover;">
                @endif

                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">— No Category —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Price (Rs.)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sale Price (optional)</label>
                            <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock Quantity</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Main Image {{ $product->image ? '(leave blank to keep current)' : '' }}</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Add More Gallery Images</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive"
                               @checked(old('is_active', $product->is_active))>
                        <label class="form-check-label" for="isActive">Active (visible in shop)</label>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Save Changes</button>
                </form>
            </div>

            @if ($product->images->isNotEmpty())
                <div class="service-card">
                    <h6 class="mb-3">Gallery Images</h6>
                    <div class="row g-2">
                        @foreach ($product->images as $img)
                            <div class="col-3 text-center">
                                <img src="{{ asset('storage/' . $img->image) }}" class="img-fluid rounded mb-1" style="aspect-ratio: 1; object-fit: cover;">
                                <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $img]) }}"
                                      onsubmit="return confirm('Remove this image?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-soft btn-sm text-danger w-100">Remove</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection