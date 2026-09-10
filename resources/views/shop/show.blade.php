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
                    @if (count($product->all_images) > 0)
                        <img src="{{ asset('storage/' . $product->all_images[0]) }}" alt="{{ $product->name }}"
                             class="img-fluid rounded mb-3" id="mainProductImage">

                        @if (count($product->all_images) > 1)
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach ($product->all_images as $img)
                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}"
                                         class="rounded product-thumb" style="width: 70px; height: 70px; object-fit: cover; cursor: pointer; border: 1px solid var(--color-border);"
                                         onclick="document.getElementById('mainProductImage').src = this.src;">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="service-card-img-placeholder rounded" style="aspect-ratio: 1;">
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
                            <div class="row g-2">
                                <div class="col-4">
                                    <form method="POST" action="{{ route('cart.add', $product) }}">
                                        @csrf
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control mb-2">
                                        <button type="submit" class="btn btn-outline-soft w-100">
                                            <i class="bi bi-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                                <div class="col-8 d-flex align-items-end">
                                    <form method="POST" action="{{ route('checkout.buy-now', $product) }}" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-accent w-100">
                                            <i class="bi bi-lightning-charge-fill"></i> Buy Now
                                        </button>
                                    </form>
                                </div>
                            </div>
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