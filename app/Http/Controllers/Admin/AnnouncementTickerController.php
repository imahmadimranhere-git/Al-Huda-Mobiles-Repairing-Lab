<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnouncementTicker;
use Illuminate\Http\Request;

class AnnouncementTickerController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $tickers = AnnouncementTicker::orderBy('display_order')->get();

        return view('admin.tickers.index', ['tickers' => $tickers]);
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.tickers.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'text' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        AnnouncementTicker::create([
            'text' => $validated['text'],
            'url' => $validated['url'] ?? null,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.tickers.index')->with('status', 'Announcement added.');
    }

    public function edit(AnnouncementTicker $ticker)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.tickers.edit', ['ticker' => $ticker]);
    }

    public function update(Request $request, AnnouncementTicker $ticker)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'text' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $ticker->update([
            'text' => $validated['text'],
            'url' => $validated['url'] ?? null,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.tickers.index')->with('status', 'Announcement updated.');
    }

    public function destroy(AnnouncementTicker $ticker)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $ticker->delete();

        return back()->with('status', 'Announcement deleted.');
    }
}