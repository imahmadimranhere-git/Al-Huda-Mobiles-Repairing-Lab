@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section class="hero">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <p class="eyebrow font-display">{{ $settings['hero_eyebrow'] }}</p>
                    <h1>{{ $settings['hero_heading'] }}</h1>
                    <p class="lead">
                        {{ $settings['hero_description'] }}
                    </p>
                    <div class="d-flex gap-3 mt-4 justify-content-center justify-content-lg-start">
                        <a href="{{ $settings['hero_button_url'] }}" class="btn btn-accent">{{ $settings['hero_button_text'] }}</a>
                        <a href="{{ route('repairs.track') }}" class="btn btn-outline-soft">Track my repair</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ticket-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="ticket-id">AHMR-20260905-0124</div>
                                <span class="ticket-status">Repairing</span>
                            </div>
                            <i class="bi bi-qr-code fs-3 text-secondary"></i>
                        </div>

                        <div class="ticket-row">
                            <span>Device</span>
                            <span>iPhone 13 Pro</span>
                        </div>
                        <div class="ticket-row">
                            <span>Issue</span>
                            <span>No display, charging normally</span>
                        </div>
                        <div class="ticket-row">
                            <span>Technician</span>
                            <span>Bilal A.</span>
                        </div>
                        <div class="ticket-row">
                            <span>Est. completion</span>
                            <span>Today, 6:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-3">Our Services</h2>
                    <p class="text-secondary mb-5">
                        Professional mobile repair services with expert diagnosis, quality parts,
                        and reliable workmanship.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($services as $service)
                    <div class="col-md-4">
                        <div class="service-card service-card-image p-0">
                            @if ($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="service-card-img">
                            @else
                                <div class="service-card-img service-card-img-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                            <div class="service-card-body">
                                <h5>{{ $service->title }}</h5>
                                <p>{{ $service->description }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-secondary">No services added yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @if ($newsItems->isNotEmpty())
        <section class="py-5" style="background: var(--color-bg-panel-alt);">
            <div class="container py-4">
                <div class="row">
                    <div class="col-lg-6">
                        <h2 class="mb-5">News &amp; Updates</h2>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach ($newsItems as $news)
                        <div class="col-md-4">
                            <div class="service-card">
                                <p class="text-secondary small mb-2">{{ $news->published_date?->format('d M Y') }}</p>
                                <h5>{{ $news->title }}</h5>
                                <p>{{ $news->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($shopCategories->isNotEmpty())
        <section class="py-5">
            <div class="container py-4">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h2 class="mb-0">Shop</h2>
                        <p class="text-secondary mb-0">Genuine parts and accessories, ready to ship.</p>
                    </div>
                </div>

                @foreach ($shopCategories as $category)
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="font-display mb-0">{{ $category->name }}</h4>
                            <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="btn btn-outline-soft btn-sm">
                                See More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>

                        <div class="row g-4">
                            @foreach ($category->products as $product)
                                <div class="col-6 col-md-4 col-lg">
                                    <a href="{{ route('shop.show', $product) }}" class="text-reset">
                                        <div class="service-card service-card-image p-0 h-100">
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="service-card-img">
                                            @else
                                                <div class="service-card-img service-card-img-placeholder">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            <div class="service-card-body">
                                                <h6 class="mb-1">{{ $product->name }}</h6>
                                                @if ($product->description)
                                                    <p class="small text-secondary mb-2">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</p>
                                                @endif
                                                @if ($product->sale_price)
                                                    <span class="text-decoration-line-through text-secondary small">Rs. {{ number_format($product->price, 2) }}</span>
                                                    <strong class="d-block">Rs. {{ number_format($product->sale_price, 2) }}</strong>
                                                @else
                                                    <strong class="d-block">Rs. {{ number_format($product->price, 2) }}</strong>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

@endsection