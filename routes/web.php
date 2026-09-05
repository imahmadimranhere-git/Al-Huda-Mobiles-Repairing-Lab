<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Home page (temporary placeholder — Phase 3 mein dynamic banayenge)
Route::get('/', function () {
    return view('home');
})->name('home');

// Guest-only (login/register)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

// Logged-in users only
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    // Book Repair
    Route::get('book-repair', [\App\Http\Controllers\RepairController::class, 'create'])->name('repairs.create');
    Route::post('book-repair', [\App\Http\Controllers\RepairController::class, 'store'])->name('repairs.store');
    Route::get('repair-confirmation/{trackingId}', [\App\Http\Controllers\RepairController::class, 'confirmation'])->name('repairs.confirmation');
});

// Admin-only routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Access denied.');
        }
        return view('admin.dashboard');
    })->name('dashboard');
});