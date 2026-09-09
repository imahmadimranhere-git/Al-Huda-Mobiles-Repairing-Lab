@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-display mb-0">{{ $order->order_number }}</h2>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-soft btn-sm">Back to My Orders</a>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
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
                        <h5 class="mb-3">Shipping Details</h5>
                        <div class="ticket-row"><span>Status</span><span>{{ ucfirst($order->status) }}</span></div>
                        <div class="ticket-row"><span>Name</span><span>{{ $order->customer_name }}</span></div>
                        <div class="ticket-row"><span>Phone</span><span>{{ $order->customer_phone }}</span></div>
                        <div class="ticket-row"><span>Address</span><span>{{ $order->shipping_address }}</span></div>
                        <div class="ticket-row"><span>Placed On</span><span>{{ $order->created_at->format('d M Y, h:i A') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection