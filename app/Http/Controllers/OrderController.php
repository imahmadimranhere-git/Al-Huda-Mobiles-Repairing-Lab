<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    // List the logged-in customer's own orders
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('orders.index', ['orders' => $orders]);
    }

    // Show one of the logged-in customer's own orders in detail
    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403, 'Access denied.');

        $order->load('items');

        return view('orders.show', ['order' => $order]);
    }
}