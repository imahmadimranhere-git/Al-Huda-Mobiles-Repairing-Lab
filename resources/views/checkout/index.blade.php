@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="font-display mb-4">Checkout</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="service-card">
                        <h5 class="mb-3">Shipping Details</h5>
                        <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="customer_name" class="form-control"
                                       value="{{ old('customer_name', auth()->user()->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="customer_phone" class="form-control"
                                       value="{{ old('customer_phone', auth()->user()->phone) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Shipping Address</label>
                                <textarea name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="service-card">
                        <h5 class="mb-3">Order Summary</h5>
                        @foreach ($cart->items as $item)
                            <div class="ticket-row">
                                <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                                <span>Rs. {{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                        <div class="ticket-row">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold">Rs. {{ number_format($cart->total, 2) }}</span>
                        </div>

                        <button type="submit" form="checkoutForm" class="btn btn-accent w-100 mt-3">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection