<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private const STATUSES = [
        'pending',
        'processing',
        'shipped',
        'completed',
        'cancelled',
    ];

    public function index(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $query = Order::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', ['orders' => $orders, 'statuses' => self::STATUSES]);
    }

    public function show(Order $order)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $order->load('user', 'items.product');

        return view('admin.orders.show', ['order' => $order, 'statuses' => self::STATUSES]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('status', 'Order status updated.');
    }
}