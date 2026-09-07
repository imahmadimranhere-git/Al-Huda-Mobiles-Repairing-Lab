<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RepairController as AdminRepairController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\WebsiteContentController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');

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
    Route::delete('technicians/{technician}', [TechnicianController::class, 'destroy'])->name('technicians.destroy');

        // Customer Management
    Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');


        // Website Content
    Route::get('website/home', [WebsiteContentController::class, 'edit'])->name('website.home');
    Route::put('website/home', [WebsiteContentController::class, 'update'])->name('website.home.update');


        // Services
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    });