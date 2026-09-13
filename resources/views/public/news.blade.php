@extends('layouts.app')

@section('title', 'News & Updates')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="font-display mb-4">News & Updates</h2>

            <div class="row g-4">
                @forelse ($newsItems as $news)
                    <div class="col-md-4">
                        <div class="service-card">
                            <p class="text-secondary small mb-2">{{ $news->published_date?->format('d M Y') }}</p>
                            <h5>{{ $news->title }}</h5>
                            <p>{{ $news->content }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-secondary">No news or updates yet.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $newsItems->links() }}
            </div>
        </div>
    </section>
@endsection