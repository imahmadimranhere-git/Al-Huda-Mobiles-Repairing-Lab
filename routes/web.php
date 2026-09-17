<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RepairController as AdminRepairController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\NewsUpdateController;
use App\Http\Controllers\Admin\WebsiteContentController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\RepairApprovalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepairDeliveryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AnnouncementTickerController;
use App\Http\Controllers\Admin\BannerController;

// Home page
Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');
// Shop — open to everyone
Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('shop/{product}', [ShopController::class, 'show'])->name('shop.show');
// Track Repair — open to everyone, no login required
Route::get('track-repair', [RepairController::class, 'trackForm'])->name('repairs.track');
Route::post('track-repair', [RepairController::class, 'trackResult'])->name('repairs.track.result');

Route::get('repairs/approve/{trackingId}', [RepairApprovalController::class, 'show'])->name('repairs.approve');
Route::post('repairs/approve/{trackingId}', [RepairApprovalController::class, 'verify'])->name('repairs.approve.verify');

// Direct tracking view by ID (used after approval, and by QR code)
Route::get('track/{trackingId}', [RepairController::class, 'trackDirect'])->name('repairs.track.result.direct');
Route::post('repairs/{trackingId}/confirm-delivery', [RepairDeliveryController::class, 'store'])->name('repairs.confirm-delivery');
Route::get('news-updates', [NewsController::class, 'index'])->name('news.index');

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

        // Cart
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/{product}/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('cart/{itemId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{itemId}', [CartController::class, 'remove'])->name('cart.remove');

        // Checkout
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('checkout/confirmation/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');    // Checkout
        Route::post('checkout/buy-now/{product}', [CheckoutController::class, 'buyNow'])->name('checkout.buy-now');
        // My Orders
    Route::get('my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');

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

        // News & Updates
    Route::get('news', [NewsUpdateController::class, 'index'])->name('news.index');
    Route::get('news/create', [NewsUpdateController::class, 'create'])->name('news.create');
    Route::post('news', [NewsUpdateController::class, 'store'])->name('news.store');
    Route::get('news/{news}/edit', [NewsUpdateController::class, 'edit'])->name('news.edit');
    Route::put('news/{news}', [NewsUpdateController::class, 'update'])->name('news.update');
    Route::delete('news/{news}', [NewsUpdateController::class, 'destroy'])->name('news.destroy');

        // Categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Products
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('products/{product}/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.destroy');
        // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    Route::post('repairs/{repair}/resend-otp', [AdminRepairController::class, 'resendOtp'])->name('repairs.resend-otp');

        // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');

        // Announcement Ticker
    Route::get('tickers', [AnnouncementTickerController::class, 'index'])->name('tickers.index');
    Route::get('tickers/create', [AnnouncementTickerController::class, 'create'])->name('tickers.create');
    Route::post('tickers', [AnnouncementTickerController::class, 'store'])->name('tickers.store');
    Route::get('tickers/{ticker}/edit', [AnnouncementTickerController::class, 'edit'])->name('tickers.edit');
    Route::put('tickers/{ticker}', [AnnouncementTickerController::class, 'update'])->name('tickers.update');
    Route::delete('tickers/{ticker}', [AnnouncementTickerController::class, 'destroy'])->name('tickers.destroy');

    // Banners
    Route::get('banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('banners/{banner}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

    
    });