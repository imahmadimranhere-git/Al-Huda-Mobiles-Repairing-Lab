@extends('layouts.admin')

@section('title', 'Services')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Services</h4>
        <a href="{{ route('admin.services.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> Add Service
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="service-card p-0">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4">Order</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th class="pe-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td class="ps-4">{{ $service->display_order }}</td>
                        <td><i class="bi {{ $service->icon }} me-1"></i> {{ $service->title }}</td>
                        <td class="text-secondary small">{{ \Illuminate\Support\Str::limit($service->description, 60) }}</td>
                        <td>
                            @if ($service->is_active)
                                <span class="ticket-status">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-outline-soft btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-soft btn-sm text-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">No services added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection