@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="font-display mb-4">My Cart</h2>

            @if ($cart->items->isEmpty())
                <div class="service-card text-center">
                    <p class="text-secondary mb-3">Your cart is empty.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-accent">Browse the Shop</a>
                </div>
            @else
                <div class="service-card p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th class="pe-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart->items as $item)
                                    <tr>
                                        <td class="ps-4">{{ $item->product->name }}</td>
                                        <td>Rs. {{ number_format($item->product->final_price, 2) }}</td>
                                        <td style="max-width: 100px;">
                                            <form method="POST" action="{{ route('cart.update', $item->id) }}" class="d-flex gap-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm">
                                                <button type="submit" class="btn btn-outline-soft btn-sm">Update</button>
                                            </form>
                                        </td>
                                        <td>Rs. {{ number_format($item->subtotal, 2) }}</td>
                                        <td class="pe-4">
                                            <form method="POST" action="{{ route('cart.remove', $item->id) }}"
                                                  onsubmit="return confirm('Remove this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-soft btn-sm text-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <div class="service-card">
                            <div class="ticket-row">
                                <span>Total</span>
                                <span class="fw-bold">Rs. {{ number_format($cart->total, 2) }}</span>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-accent w-100 mt-3">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection