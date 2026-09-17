<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $banners = Banner::orderBy('display_order')->get();

        return view('admin.banners.index', ['banners' => $banners]);
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        // All three sizes are mandatory — you cannot add a desktop banner
        // without also providing tablet and mobile versions.
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image_desktop' => ['required', 'image', 'max:3072'],
            'image_tablet' => ['required', 'image', 'max:3072'],
            'image_mobile' => ['required', 'image', 'max:3072'],
            'url' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Banner::create([
            'title' => $validated['title'] ?? null,
            'image_desktop' => $request->file('image_desktop')->store('banners', 'public'),
            'image_tablet' => $request->file('image_tablet')->store('banners', 'public'),
            'image_mobile' => $request->file('image_mobile')->store('banners', 'public'),
            'url' => $validated['url'] ?? null,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.banners.index')->with('status', 'Banner added.');
    }

    public function edit(Banner $banner)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.banners.edit', ['banner' => $banner]);
    }

    public function update(Request $request, Banner $banner)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image_desktop' => ['nullable', 'image', 'max:3072'],
            'image_tablet' => ['nullable', 'image', 'max:3072'],
            'image_mobile' => ['nullable', 'image', 'max:3072'],
            'url' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imageDesktop = $banner->image_desktop;
        if ($request->hasFile('image_desktop')) {
            Storage::disk('public')->delete($banner->image_desktop);
            $imageDesktop = $request->file('image_desktop')->store('banners', 'public');
        }

        $imageTablet = $banner->image_tablet;
        if ($request->hasFile('image_tablet')) {
            Storage::disk('public')->delete($banner->image_tablet);
            $imageTablet = $request->file('image_tablet')->store('banners', 'public');
        }

        $imageMobile = $banner->image_mobile;
        if ($request->hasFile('image_mobile')) {
            Storage::disk('public')->delete($banner->image_mobile);
            $imageMobile = $request->file('image_mobile')->store('banners', 'public');
        }

        $banner->update([
            'title' => $validated['title'] ?? null,
            'image_desktop' => $imageDesktop,
            'image_tablet' => $imageTablet,
            'image_mobile' => $imageMobile,
            'url' => $validated['url'] ?? null,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.banners.index')->with('status', 'Banner updated.');
    }

    public function destroy(Banner $banner)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        Storage::disk('public')->delete([$banner->image_desktop, $banner->image_tablet, $banner->image_mobile]);
        $banner->delete();

        return back()->with('status', 'Banner deleted.');
    }
}