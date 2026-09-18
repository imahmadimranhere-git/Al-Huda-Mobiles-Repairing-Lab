<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteContentController extends Controller
{
    public function edit()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $settings = [
            'site_logo' => SiteSetting::get('site_logo'),
            'hero_eyebrow' => SiteSetting::get('hero_eyebrow'),
            'hero_heading' => SiteSetting::get('hero_heading'),
            'hero_description' => SiteSetting::get('hero_description'),
            'hero_button_text' => SiteSetting::get('hero_button_text'),
            'hero_button_url' => SiteSetting::get('hero_button_url'),
            'hero_video_url' => SiteSetting::get('hero_video_url'),
            'contact_phone' => SiteSetting::get('contact_phone'),
            'contact_whatsapp' => SiteSetting::get('contact_whatsapp'),
            'contact_email' => SiteSetting::get('contact_email'),
            'contact_address' => SiteSetting::get('contact_address'),
            'admin_whatsapp_number' => SiteSetting::get('admin_whatsapp_number'),
            'delivery_disclaimer' => SiteSetting::get('delivery_disclaimer'),
            'social_facebook' => SiteSetting::get('social_facebook'),
            'social_instagram' => SiteSetting::get('social_instagram'),
            'social_youtube' => SiteSetting::get('social_youtube'),
        ];

        return view('admin.website.home', ['settings' => $settings]);
    }

    public function update(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'logo' => ['nullable', 'image', 'max:1024'],
            'hero_video' => ['nullable', 'mimetypes:video/mp4', 'max:20480'],
            'hero_eyebrow' => ['nullable', 'string', 'max:255'],
            'hero_heading' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string', 'max:1000'],
            'hero_button_text' => ['nullable', 'string', 'max:50'],
            'hero_button_url' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'contact_whatsapp' => ['nullable', 'string', 'max:30'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_address' => ['nullable', 'string', 'max:255'],
            'admin_whatsapp_number' => ['nullable', 'string', 'max:20'],
            'delivery_disclaimer' => ['nullable', 'string', 'max:2000'],
            'social_facebook' => ['nullable', 'string', 'max:255'],
            'social_instagram' => ['nullable', 'string', 'max:255'],
            'social_youtube' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('logo')) {
            $oldLogo = SiteSetting::get('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('logo')->store('branding', 'public');
            SiteSetting::set('site_logo', $path);
        }

        if ($request->hasFile('hero_video')) {
            $oldVideo = SiteSetting::get('hero_video_url');
            if ($oldVideo) {
                Storage::disk('public')->delete($oldVideo);
            }
            $path = $request->file('hero_video')->store('branding', 'public');
            SiteSetting::set('hero_video_url', $path);
        }

        unset($validated['logo'], $validated['hero_video']);

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return back()->with('status', 'Website content updated. Changes are live on the home page.');
    }
}