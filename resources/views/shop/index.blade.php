@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="font-display mb-4">Shop</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="row g-4">
                {{-- Left filter sidebar --}}
                <div class="col-lg-3">
                    <div class="shop-filter-sidebar">
                        <form method="GET" action="{{ route('shop.index') }}">
                            <div class="mb-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search products">
                            </div>

                            <div class="mb-3">
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

                            <div class="mb-3">
                                <label class="form-label">Price Range (Rs.)</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min"
                                           value="{{ request('min_price') }}" min="0">
                                    <span>—</span>
                                    <input type="number" name="max_price" class="form-control" placeholder="Max"
                                           value="{{ request('max_price') }}" min="0">
                                </div>
                                @if ($priceBounds->min_price !== null)
                                    <div class="form-text">Range: Rs. {{ number_format($priceBounds->min_price) }} – Rs. {{ number_format($priceBounds->max_price) }}</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sort By</label>
                                <select name="sort" class="form-select">
                                    <option value="latest" @selected(request('sort', 'latest') === 'latest')>Newest</option>
                                    <option value="price_low" @selected(request('sort') === 'price_low')>Price: Low to High</option>
                                    <option value="price_high" @selected(request('sort') === 'price_high')>Price: High to Low</option>
                                </select>
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" name="in_stock" value="1" class="form-check-input" id="inStockOnly"
                                       @checked(request('in_stock'))>
                                <label class="form-check-label" for="inStockOnly">In stock only</label>
                            </div>

                            <button type="submit" class="btn btn-accent w-100 mb-2">Apply Filters</button>
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-soft w-100">Clear Filters</a>
                        </form>
                    </div>
                </div>

                {{-- Product grid --}}
                <div class="col-lg-9">
                    <div class="row row-cols-2 row-cols-md-3 g-3">
                        @forelse ($products as $product)
                            <div class="col">
                                @include('partials.product-card', ['product' => $product])
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
            </div>
        </div>
    </section>
@endsection