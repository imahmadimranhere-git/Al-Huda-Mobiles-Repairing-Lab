@extends('layouts.admin')

@section('title', 'Announcement Ticker')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Announcement Ticker</h4>
        <a href="{{ route('admin.tickers.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> Add Announcement
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
                        <th class="ps-4">Order</th>
                        <th>Text</th>
                        <th>Status</th>
                        <th class="pe-4"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickers as $ticker)
                        <tr>
                            <td class="ps-4">{{ $ticker->display_order }}</td>
                            <td>{{ $ticker->text }}</td>
                            <td>
                                @if ($ticker->is_active)
                                    <span class="ticket-status">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.tickers.edit', $ticker) }}" class="btn btn-outline-soft btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.tickers.destroy', $ticker) }}"
                                          onsubmit="return confirm('Delete this announcement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-soft btn-sm text-danger w-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">No announcements added yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection