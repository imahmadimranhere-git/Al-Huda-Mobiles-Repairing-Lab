<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsUpdate;
use Illuminate\Http\Request;

class NewsUpdateController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $newsItems = NewsUpdate::orderBy('display_order')->orderByDesc('published_date')->get();

        return view('admin.news.index', ['newsItems' => $newsItems]);
    }

    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:1000'],
            'published_date' => ['nullable', 'date'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]);

        NewsUpdate::create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'published_date' => $validated['published_date'] ?? now(),
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('admin.news.index')->with('status', 'News item added.');
    }

    public function edit(NewsUpdate $news)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.news.edit', ['news' => $news]);
    }

    public function update(Request $request, NewsUpdate $news)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string', 'max:1000'],
            'published_date' => ['nullable', 'date'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $news->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'published_date' => $validated['published_date'] ?? $news->published_date,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.news.index')->with('status', 'News item updated.');
    }

    public function destroy(NewsUpdate $news)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $news->delete();

        return back()->with('status', 'News item deleted.');
    }
}