@extends('layouts.app')

@section('title', 'Track Repair')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h2 class="mb-2 font-display text-center">Track Your Repair</h2>
                    <p class="text-secondary mb-4 text-center">
                        Enter the tracking ID you received when you booked your repair.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="service-card">
                        <form method="POST" action="{{ route('repairs.track.result') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tracking ID</label>
                                <input type="text" name="tracking_id" class="form-control"
                                       placeholder="e.g. AHMR-20260905-0124" value="{{ old('tracking_id') }}" required>
                            </div>
                            <button type="submit" class="btn btn-accent w-100">Check Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection