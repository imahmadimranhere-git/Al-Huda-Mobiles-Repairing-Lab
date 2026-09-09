@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    <h2 class="font-display mt-3 mb-2">Order Placed</h2>
                    <p class="text-secondary mb-4">Thank you — your order has been received.</p>

                    <div class="ticket-card mx-auto" style="margin-left: auto; margin-right: auto; max-width: 100%;">
                        <div class="ticket-id fs-5">{{ $order->order_number }}</div>
                        <span class="ticket-status">{{ ucfirst($order->status) }}</span>

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

                    <a href="{{ route('home') }}" class="btn btn-outline-soft mt-4">Back to Home</a>
                </div>
            </div>
        </div>
    </section>
@endsection