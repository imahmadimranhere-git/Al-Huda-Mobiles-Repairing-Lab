<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $services = Service::orderBy('display_order')->get();

        return view('admin.services.index', ['services' => $services]);
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:2048'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
        }

        Service::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.services.index')->with('status', 'Service added.');
    }

    public function edit(Service $service)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.services.edit', ['service' => $service]);
    }

    public function update(Request $request, Service $service)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'max:2048'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imagePath = $service->image;
        if ($request->hasFile('image')) {
            // Remove the old image so storage doesn't fill up with unused files
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $imagePath = $request->file('image')->store('services', 'public');
        }

        $service->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.services.index')->with('status', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return back()->with('status', 'Service deleted.');
    }
}