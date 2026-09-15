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
                        <form method="POST" action="{{ route('repairs.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Your Name</label>
                                    <input type="text" name="customer_name" class="form-control"
                                           value="{{ old('customer_name', auth()->user()->name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="customer_phone" class="form-control"
                                           value="{{ old('customer_phone', auth()->user()->phone) }}" required>
                                </div>
                            </div>

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

                            <div class="mb-3">
                                <label class="form-label">Describe the Issue</label>
                                <textarea name="issue" class="form-control" rows="4"
                                          placeholder="e.g. Screen is cracked and touch doesn't respond in the top half" required>{{ old('issue') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload a Photo of Your Device</label>
                                <input type="file" name="device_photo" class="form-control" accept="image/*" required>
                                <div class="form-text">This helps our technicians assess the device's current condition before you drop it off.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">How will you deliver the device?</label>
                                <select name="delivery_method" class="form-select" required>
                                    <option value="drop-off" @selected(old('delivery_method') === 'drop-off')>I will drop it off at the shop</option>
                                    <option value="courier" @selected(old('delivery_method') === 'courier')>Courier / Pickup requested</option>
                                </select>
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" name="disclaimer_accepted" value="1" class="form-check-input" id="disclaimerCheck" required>
                                <label class="form-check-label small" for="disclaimerCheck">
                                    {{ \App\Models\SiteSetting::get('delivery_disclaimer') }}
                                </label>
                            </div>

                            <button type="submit" class="btn btn-accent w-100" id="bookRepairBtn" disabled>
                                Submit Repair Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('disclaimerCheck').addEventListener('change', function () {
            document.getElementById('bookRepairBtn').disabled = !this.checked;
        });
    </script>
@endsection