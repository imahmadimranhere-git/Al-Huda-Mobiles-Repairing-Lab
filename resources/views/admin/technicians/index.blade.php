@extends('layouts.admin')

@section('title', 'Technicians')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Technicians</h4>
        <a href="{{ route('admin.technicians.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> Add Technician
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
                    <th class="ps-4">Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th class="pe-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($technicians as $technician)
                    <tr>
                        <td class="ps-4">{{ $technician->name }}</td>
                        <td>{{ $technician->email }}</td>
                        <td>{{ $technician->phone ?? '—' }}</td>
                                                <td class="pe-4">
                            <div class="table-actions">
                                <a href="{{ route('admin.technicians.edit', $technician) }}" class="btn btn-outline-soft btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.technicians.destroy', $technician) }}"
                                      onsubmit="return confirm('Delete this technician? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-soft btn-sm text-danger w-100">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-4">No technicians added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>>
@endsection