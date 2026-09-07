<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // List all customers (role = user), with basic search
    public function index(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $query = User::whereHas('role', fn ($q) => $q->where('slug', 'user'))
            ->withCount('repairs')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('admin.customers.index', ['customers' => $customers]);
    }

    // Show a single customer's profile + their repair history
    public function show(User $customer)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');
        abort_unless($customer->role?->slug === 'user', 404);

        $customer->load(['repairs' => fn ($q) => $q->latest()]);

        return view('admin.customers.show', ['customer' => $customer]);
    }
}