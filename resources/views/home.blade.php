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
    Professional mobile repair services with expert diagnosis, quality parts, and reliable workmanship.
</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($services as $service)
                    <div class="col-md-4">
                        <div class="service-card">
                            <div class="icon"><i class="bi {{ $service->icon }}"></i></div>
                            <h5>{{ $service->title }}</h5>
                            <p>{{ $service->description }}</p>
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

    

@endsection