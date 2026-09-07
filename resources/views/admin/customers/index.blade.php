@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
    <h4 class="font-display mb-4">Customers</h4>

    <div class="service-card mb-4">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                       placeholder="Name, email or phone">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-accent w-100">Search</button>
            </div>
        </form>
    </div>

    <div class="service-card p-0">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th class="ps-4">Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Repairs</th>
                    <th>Joined</th>
                    <th class="pe-4"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td class="ps-4">{{ $customer->name }}</td>
                        <td>{{ $customer->email ?? '—' }}</td>
                        <td>{{ $customer->phone ?? '—' }}</td>
                        <td>{{ $customer->repairs_count }}</td>
                        <td>{{ $customer->created_at->format('d M Y') }}</td>
                        <td class="pe-4 text-end">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-soft btn-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $customers->links() }}
    </div>
@endsection