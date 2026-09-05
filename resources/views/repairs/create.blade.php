@extends('layouts.app')

@section('title', 'Book a Repair')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <h2 class="mb-2 font-display">Book a Repair</h2>
                    <p class="text-secondary mb-4">
                        Tell us about your device and the issue — we'll assign
                        a technician and give you a tracking ID to follow its progress.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="service-card">
                        <form method="POST" action="{{ route('repairs.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Device Brand</label>
                                <input type="text" name="device_brand" class="form-control"
                                       value="{{ old('device_brand') }}" placeholder="e.g. Samsung, Apple, Xiaomi" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Device Model</label>
                                <input type="text" name="device_model" class="form-control"
                                       value="{{ old('device_model') }}" placeholder="e.g. Galaxy S23, iPhone 13" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Describe the Issue</label>
                                <textarea name="issue" class="form-control" rows="4"
                                          placeholder="e.g. Screen is cracked and touch doesn't respond in the top half" required>{{ old('issue') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-accent w-100">Submit Repair Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection