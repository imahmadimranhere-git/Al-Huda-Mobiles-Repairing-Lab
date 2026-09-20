@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="font-display mb-4">Our Services</h2>

            <div class="row g-4">
                @forelse ($services as $service)
                    <div class="col-md-4">
                        <div class="service-card service-card-image">
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

            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    </section>
@endsection