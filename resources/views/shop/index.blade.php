@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="font-display mb-4">Shop</h2>

            <div class="service-card mb-4">
                <form method="GET" action="{{ route('shop.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search products">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-accent w-100">Filter</button>
                    </div>
                </form>
            </div>

            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-md-4">
                        <div class="service-card service-card-image p-0">
                            <a href="{{ route('shop.show', $product) }}">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="service-card-img">
                                @else
                                    <div class="service-card-img service-card-img-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="service-card-body">
                                <h5><a href="{{ route('shop.show', $product) }}" class="text-reset">{{ $product->name }}</a></h5>
                                <p class="mb-2">
                                    @if ($product->sale_price)
                                        <span class="text-decoration-line-through text-secondary small">Rs. {{ number_format($product->price, 2) }}</span>
                                        <strong>Rs. {{ number_format($product->sale_price, 2) }}</strong>
                                    @else
                                        <strong>Rs. {{ number_format($product->price, 2) }}</strong>
                                    @endif
                                </p>
                                @if ($product->isInStock())
                                    <a href="{{ route('shop.show', $product) }}" class="btn btn-accent btn-sm w-100">View Product</a>
                                @else
                                    <span class="badge bg-secondary">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-secondary">No products found.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </section>
@endsection