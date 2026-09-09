@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <section class="py-5">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="row g-5">
                <div class="col-lg-6">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    @else
                        <div class="service-card-img service-card-img-placeholder rounded" style="aspect-ratio: 1;">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif
                </div>

                <div class="col-lg-6">
                    @if ($product->category)
                        <p class="text-secondary small mb-1">{{ $product->category->name }}</p>
                    @endif
                    <h2 class="font-display mb-3">{{ $product->name }}</h2>

                    <div class="mb-3">
                        @if ($product->sale_price)
                            <span class="text-decoration-line-through text-secondary">Rs. {{ number_format($product->price, 2) }}</span>
                            <span class="fs-4 fw-bold ms-2">Rs. {{ number_format($product->sale_price, 2) }}</span>
                        @else
                            <span class="fs-4 fw-bold">Rs. {{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <p class="text-secondary mb-4">{{ $product->description }}</p>

                    @if ($product->isInStock())
                        @auth
                            <form method="POST" action="{{ route('cart.add', $product) }}" class="d-flex gap-2">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="max-width: 100px;">
                                <button type="submit" class="btn btn-accent">Add to Cart</button>
                            </form>
                            <p class="text-secondary small mt-2">{{ $product->stock }} in stock</p>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-accent">Login to Buy</a>
                        @endauth
                    @else
                        <span class="badge bg-secondary">Out of Stock</span>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection