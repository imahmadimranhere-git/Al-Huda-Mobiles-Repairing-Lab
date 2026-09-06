<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RepairController as AdminRepairController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RepairController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Track Repair — open to everyone, no login required
Route::get('track-repair', [RepairController::class, 'trackForm'])->name('repairs.track');
Route::post('track-repair', [RepairController::class, 'trackResult'])->name('repairs.track.result');

// Guest-only routes (login/register)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

// Logged-in users only
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    // Customer Dashboard
    Route::get('my-dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    // Book Repair
    Route::get('book-repair', [RepairController::class, 'create'])->name('repairs.create');
    Route::post('book-repair', [RepairController::class, 'store'])->name('repairs.store');
    Route::get('repair-confirmation/{trackingId}', [RepairController::class, 'confirmation'])->name('repairs.confirmation');
});

// Admin-only routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Repair Management
    Route::get('repairs', [AdminRepairController::class, 'index'])->name('repairs.index');
    Route::get('repairs/walk-in', [AdminRepairController::class, 'walkInCreate'])->name('repairs.walk-in.create');
    Route::post('repairs/walk-in', [AdminRepairController::class, 'walkInStore'])->name('repairs.walk-in.store');
    Route::get('repairs/{repair}', [AdminRepairController::class, 'show'])->name('repairs.show');
    Route::put('repairs/{repair}/status', [AdminRepairController::class, 'updateStatus'])->name('repairs.update-status');

    // Technician Management
    Route::get('technicians', [TechnicianController::class, 'index'])->name('technicians.index');
    Route::get('technicians/create', [TechnicianController::class, 'create'])->name('technicians.create');
    Route::post('technicians', [TechnicianController::class, 'store'])->name('technicians.store');
    Route::get('technicians/{technician}/edit', [TechnicianController::class, 'edit'])->name('technicians.edit');
    Route::put('technicians/{technician}', [TechnicianController::class, 'update'])->name('technicians.update');
    Route::put('technicians/{technician}/toggle-status', [TechnicianController::class, 'toggleStatus'])->name('technicians.toggle-status');
});