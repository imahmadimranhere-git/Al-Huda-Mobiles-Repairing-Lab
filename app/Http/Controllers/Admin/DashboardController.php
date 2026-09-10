<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Repair;
use App\Models\Role;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $customerRole = Role::where('slug', 'user')->first();
        $totalCustomers = User::where('role_id', $customerRole?->id)->count();

        $activeRepairs = Repair::whereNotIn('status', ['completed', 'cancelled'])->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalSales = Order::where('status', 'completed')->sum('total');

        return view('admin.dashboard', [
            'totalCustomers' => $totalCustomers,
            'activeRepairs' => $activeRepairs,
            'pendingOrders' => $pendingOrders,
            'totalSales' => $totalSales,
        ]);
    }
}