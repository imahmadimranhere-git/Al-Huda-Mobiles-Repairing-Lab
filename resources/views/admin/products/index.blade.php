@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">Products</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg"></i> Add Product
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="service-card mb-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Product name">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-accent w-100">Search</button>
            </div>
        </form>
    </div>

    <div class="service-card p-0">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="pe-4"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="ps-4">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                @else
                                    <span class="text-secondary small">No image</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '—' }}</td>
                            <td>
                                @if ($product->sale_price)
                                    <span class="text-decoration-line-through text-secondary small">Rs. {{ number_format($product->price, 2) }}</span>
                                    <br>Rs. {{ number_format($product->sale_price, 2) }}
                                @else
                                    Rs. {{ number_format($product->price, 2) }}
                                @endif
                            </td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if ($product->is_active)
                                    <span class="ticket-status">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="pe-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-soft btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('Delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-soft btn-sm text-danger w-100">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">No products added yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
@endsection