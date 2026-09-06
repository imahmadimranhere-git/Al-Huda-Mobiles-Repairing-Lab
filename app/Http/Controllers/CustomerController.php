<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Customer's own dashboard — shows their repairs only
    public function dashboard(Request $request)
    {
        $repairs = $request->user()
            ->repairs()
            ->latest()
            ->get();

        return view('customer.dashboard', ['repairs' => $repairs]);
    }
}