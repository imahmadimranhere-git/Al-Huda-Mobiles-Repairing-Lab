@extends('layouts.admin')

@section('title', 'Banners')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Home Page Banners</h4>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> Add Banner
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
                        <th class="ps-4">Desktop</th>
                        <th>Title</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="pe-4"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($banners as $banner)
                        <tr>
                            <td class="ps-4">
                                <img src="{{ asset('storage/' . $banner->image_desktop) }}" style="width: 100px; height: 40px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td>{{ $banner->title ?? '—' }}</td>
                            <td>{{ $banner->display_order }}</td>
                            <td>
                                @if ($banner->is_active)
                                    <span class="ticket-status">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-outline-soft btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}"
                                          onsubmit="return confirm('Delete this banner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-soft btn-sm text-danger w-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary py-4">No banners added yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection