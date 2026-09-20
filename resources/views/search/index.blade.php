@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="font-display mb-2">Search Results</h2>
            <p class="text-secondary mb-4">
                @if ($query)
                    Showing results for "<strong>{{ $query }}</strong>"
                @else
                    Enter a search term to find products, services and news.
                @endif
            </p>

            @if ($query && $products->isEmpty() && $services->isEmpty() && $newsItems->isEmpty())
                <div class="service-card text-center">
                    <p class="text-secondary mb-0">No results found for "{{ $query }}".</p>
                </div>
            @endif

            @if ($products->isNotEmpty())
                <h4 class="font-display mb-3">Products</h4>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 mb-5">
                    @foreach ($products as $product)
                        <div class="col">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($services->isNotEmpty())
                <h4 class="font-display mb-3">Services</h4>
                <div class="row g-4 mb-5">
                    @foreach ($services as $service)
                        <div class="col-md-4">
                            <div class="service-card">
                                <h5>{{ $service->title }}</h5>
                                <p>{{ $service->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($newsItems->isNotEmpty())
                <h4 class="font-display mb-3">News &amp; Updates</h4>
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
            @endif
        </div>
    </section>
@endsection