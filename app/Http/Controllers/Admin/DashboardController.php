<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $customerRole = Role::where('slug', 'user')->first();

        $totalCustomers = User::where('role_id', $customerRole?->id)->count();

        return view('admin.dashboard', [
            'totalCustomers' => $totalCustomers,
            'activeRepairs' => 0,
            'pendingOrders' => 0,
            'totalSales' => 0,
        ]);
    }
}