@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section class="hero">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <p class="eyebrow font-display">Precision mobile diagnostics</p>
                    <h1>We fix what your phone can't tell you is wrong.</h1>
                    <p class="lead">
                        Micro-soldering, motherboard repair and full diagnostics,
                        done by trained technicians and tracked from the moment
                        it reaches our bench to the moment it's back in your hand.
                    </p>
                    <div class="d-flex gap-3 mt-4 justify-content-center justify-content-lg-start">
                        <a href="{{ route('repairs.create') }}" class="btn btn-accent">Book a repair</a>
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
                    <h2 class="mb-3">Built like a lab, not a counter.</h2>
                    <p class="text-secondary mb-5">
                        Every device that comes in gets diagnosed, tracked and
                        documented — not guessed at.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="icon"><i class="bi bi-cpu"></i></div>
                        <h5>Motherboard Repair</h5>
                        <p>Component-level diagnostics and micro-soldering for faults that a screen or battery swap won't fix.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="icon"><i class="bi bi-phone"></i></div>
                        <h5>Screen &amp; Battery</h5>
                        <p>Genuine and high-grade replacement parts, fitted and tested before your device leaves the bench.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="icon"><i class="bi bi-qr-code-scan"></i></div>
                        <h5>Live Tracking</h5>
                        <p>Every repair gets a tracking ID and QR code, so you always know exactly where your device is.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="mb-1">Have a device that needs looking at?</h4>
                <p class="text-secondary mb-0">Book a slot and drop it off, or track a repair already in progress.</p>
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('repairs.create') }}" class="btn btn-accent">Book a repair</a>
                <a href="{{ route('repairs.track') }}" class="btn btn-outline-soft">Track my repair</a>
            </div>
        </div>
    </section>

@endsection