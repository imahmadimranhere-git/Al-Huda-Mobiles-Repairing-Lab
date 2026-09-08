@extends('layouts.admin')

@section('title', 'News & Updates')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">News & Updates</h4>
        <a href="{{ route('admin.news.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> Add News
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="service-card p-0">
        <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4">Title</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="pe-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($newsItems as $news)
                    <tr>
                        <td class="ps-4">{{ $news->title }}</td>
                        <td>{{ $news->published_date?->format('d M Y') ?? '—' }}</td>
                        <td>
                            @if ($news->is_active)
                                <span class="ticket-status">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                                                <td class="pe-4">
                            <div class="table-actions">
                                <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-outline-soft btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.news.destroy', $news) }}"
                                      onsubmit="return confirm('Delete this news item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-soft btn-sm text-danger w-100">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-4">No news items added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
@endsection