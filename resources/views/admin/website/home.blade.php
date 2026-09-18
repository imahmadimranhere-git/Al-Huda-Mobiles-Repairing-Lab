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

    <form method="POST" action="{{ route('admin.website.home.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="service-card mb-4">
            <h5 class="mb-3">Site Logo</h5>

            @if ($settings['site_logo'])
                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current logo"
                     class="mb-3" style="height: 50px; object-fit: contain;">
            @endif

            <input type="file" name="logo" class="form-control" accept="image/*">
            <div class="form-text">Recommended: a transparent PNG, roughly 200×50px. Leave blank to keep the current logo.</div>
        </div>

        <div class="service-card mb-4">
            <h5 class="mb-3">Hero Video</h5>

            @if ($settings['hero_video_url'])
                <video controls class="mb-3" style="max-height: 150px; display: block;">
                    <source src="{{ asset('storage/' . $settings['hero_video_url']) }}" type="video/mp4">
                </video>
            @endif

            <input type="file" name="hero_video" class="form-control" accept="video/mp4">
            <div class="form-text">MP4 only, max 20MB. When set, this video replaces the tracking-ticket preview on the home page. Leave blank to keep the current video.</div>
        </div>

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

        <div class="service-card mb-4">
            <h5 class="mb-3">Social Media Links</h5>
            <p class="text-secondary small mb-3">Shown as icons in the footer. Leave blank to hide any icon.</p>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Facebook URL</label>
                    <input type="text" name="social_facebook" class="form-control" value="{{ old('social_facebook', $settings['social_facebook']) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Instagram URL</label>
                    <input type="text" name="social_instagram" class="form-control" value="{{ old('social_instagram', $settings['social_instagram']) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">YouTube URL</label>
                    <input type="text" name="social_youtube" class="form-control" value="{{ old('social_youtube', $settings['social_youtube']) }}">
                </div>
            </div>
        </div>

        <div class="service-card mb-4">
            <h5 class="mb-3">Delivery Confirmation & Notifications</h5>

            <div class="mb-3">
                <label class="form-label">Admin WhatsApp Number (with country code, no + or spaces)</label>
                <input type="text" name="admin_whatsapp_number" class="form-control"
                       value="{{ old('admin_whatsapp_number', $settings['admin_whatsapp_number']) }}" placeholder="923001234567">
                <div class="form-text">Customers' "device received" WhatsApp messages will be pre-filled to this number.</div>
            </div>

            <div class="mb-0">
                <label class="form-label">Liability Disclaimer (shown as a checkbox on Book Repair)</label>
                <textarea name="delivery_disclaimer" class="form-control" rows="4">{{ old('delivery_disclaimer', $settings['delivery_disclaimer']) }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-accent">Save Changes</button>
    </form>
@endsection