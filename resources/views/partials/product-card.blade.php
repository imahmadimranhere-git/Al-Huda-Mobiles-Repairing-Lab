<div class="product-card">
    <a href="{{ route('shop.show', $product) }}" class="product-card-img-wrap">
        @if ($product->cover_image)
            <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->name }}" class="product-card-img">
        @else
            <div class="product-card-img-placeholder"><i class="bi bi-image"></i></div>
        @endif
    </a>

    <div class="product-card-body">
        <h6 class="product-card-title">
            <a href="{{ route('shop.show', $product) }}" class="text-reset">{{ $product->name }}</a>
        </h6>

        <p class="product-card-desc">{{ $product->description }}</p>

        <div class="product-card-price">
            @if ($product->sale_price)
                <span class="old-price">Rs. {{ number_format($product->price, 2) }}</span>Rs. {{ number_format($product->sale_price, 2) }}
            @else
                Rs. {{ number_format($product->price, 2) }}
            @endif
        </div>

        @if ($product->isInStock())
            @auth
                <div class="product-card-actions">
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-soft btn-sm">
                            <i class="bi bi-cart-plus"></i> Add
                        </button>
                    </form>
                    <form method="POST" action="{{ route('checkout.buy-now', $product) }}">
                        @csrf
                        <button type="submit" class="btn btn-accent btn-sm">
                            <i class="bi bi-lightning-charge-fill"></i> Buy Now
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-accent btn-sm w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Login to Buy
                </a>
            @endauth
        @else
            <span class="badge bg-secondary">Out of Stock</span>
        @endif
    </div>
</div>