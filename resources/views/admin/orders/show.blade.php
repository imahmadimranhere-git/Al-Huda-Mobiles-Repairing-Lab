@extends('layouts.admin')

@section('title', 'Order Detail')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="font-display mb-0">{{ $order->order_number }}</h4>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-soft btn-sm">Back to Orders</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            <div class="service-card mb-4">
                <h5 class="mb-3">Customer & Shipping</h5>
                <div class="ticket-row"><span>Name</span><span>{{ $order->customer_name }}</span></div>
                <div class="ticket-row"><span>Phone</span><span>{{ $order->customer_phone }}</span></div>
                <div class="ticket-row"><span>Address</span><span>{{ $order->shipping_address }}</span></div>
            </div>

            <div class="service-card">
                <h5 class="mb-3">Items</h5>
                @foreach ($order->items as $item)
                    <div class="ticket-row">
                        <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                        <span>Rs. {{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
                <div class="ticket-row">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold">Rs. {{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="service-card">
                <h5 class="mb-3">Update Status</h5>
                                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" onsubmit="return confirmOrderStatus(this);">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <select name="status" class="form-select" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Save</button>
                </form>
            </div>
        </div>
    </div>


<script>
    function confirmOrderStatus(form) {
        const status = form.querySelector('select[name="status"]').value;
        if (status === 'completed') {
            return confirm('Mark this order as Completed? This will finalize the order.');
        }
        return true;
    }
</script>

@endsection