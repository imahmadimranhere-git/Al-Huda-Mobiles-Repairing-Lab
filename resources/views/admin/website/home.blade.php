@extends('layouts.admin')

@section('title', 'Website Content — Home Page')

@section('content')
    <h4 class="font-display mb-4">Home Page Content</h4>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.website.home.update') }}">
        @csrf
        @method('PUT')

        <div class="service-card mb-4">
            <h5 class="mb-3">Hero Section</h5>

            <div class="mb-3">
                <label class="form-label">Eyebrow Text (small line above the heading)</label>
                <input type="text" name="hero_eyebrow" class="form-control" value="{{ old('hero_eyebrow', $settings['hero_eyebrow']) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Main Heading</label>
                <input type="text" name="hero_heading" class="form-control" value="{{ old('hero_heading', $settings['hero_heading']) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', $settings['hero_description']) }}</textarea>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Button Text</label>
                    <input type="text" name="hero_button_text" class="form-control" value="{{ old('hero_button_text', $settings['hero_button_text']) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button Link</label>
                    <input type="text" name="hero_button_url" class="form-control" value="{{ old('hero_button_url', $settings['hero_button_url']) }}"
                           placeholder="e.g. /book-repair or https://wa.me/923001234567">
                    <div class="form-text">Where the button should take visitors — an internal page or a full URL.</div>
                </div>
            </div>
        </div>

        <div class="service-card mb-4">
            <h5 class="mb-3">Contact Information</h5>
            <p class="text-secondary small mb-3">Shown in the site footer.</p>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone']) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">WhatsApp</label>
                    <input type="text" name="contact_whatsapp" class="form-control" value="{{ old('contact_whatsapp', $settings['contact_whatsapp']) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email']) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input type="text" name="contact_address" class="form-control" value="{{ old('contact_address', $settings['contact_address']) }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-accent">Save Changes</button>
    </form>
@endsection