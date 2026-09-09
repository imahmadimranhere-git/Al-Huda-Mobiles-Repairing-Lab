@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="font-display mb-4">My Orders</h2>

            @if ($orders->isEmpty())
                <div class="service-card text-center">
                    <p class="text-secondary mb-3">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-accent">Browse the Shop</a>
                </div>
            @else
                <div class="service-card p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="pe-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="ps-4">{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>Rs. {{ number_format($order->total, 2) }}</td>
                                        <td><span class="ticket-status">{{ ucfirst($order->status) }}</span></td>
                                        <td class="pe-4">
                                            <div class="table-actions">
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-soft btn-sm">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection