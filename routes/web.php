<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BecomeMerchantController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Merchant;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ServiceController;
use App\Livewire\Merchant\OrderDetail;
use App\Livewire\Merchant\ProductList;
use App\Livewire\Merchant\PropertyList;
use App\Livewire\Merchant\ServiceList;
use Illuminate\Support\Facades\Route;

// Auth routes (Breeze)
require __DIR__ . '/auth.php';

// Google OAuth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

// Dashboard redirect (used by Breeze auth controllers)
Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        \App\Enums\UserRole::Admin => redirect()->route('admin.dashboard'),
        \App\Enums\UserRole::Merchant => redirect()->route('merchant.dashboard'),
        default => redirect()->route('home'),
    };
})->middleware('auth')->name('dashboard');

// =============================================
// PUBLIC ROUTES
// =============================================
Route::get('/', HomeController::class)->name('home');
Route::get('/about', fn() => view('pages.about'))->name('about');

// Properties
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');

// Contact
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

// =============================================
// AUTHENTICATED ROUTES (any role)
// =============================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', \App\Livewire\ProfilePage::class)->name('profile.edit');
    Route::get('/guide', fn() => view('pages.guide'))->name('user-guide');

    // Become a Merchant (for customers who want to sell)
    Route::get('/become-a-seller', [BecomeMerchantController::class, 'create'])->name('become-seller');
    Route::post('/become-a-seller', [BecomeMerchantController::class, 'store'])->name('become-seller.store');
});

// =============================================
// CUSTOMER ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'role:customer,merchant'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/payment', [OrderController::class, 'submitPayment'])->name('orders.payment');
    Route::delete('/orders/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// =============================================
// MERCHANT ROUTES (also accessible by admin)
// =============================================
Route::middleware(['auth', 'verified', 'role:merchant,admin'])->prefix('merchant')->name('merchant.')->group(function () {
    // Pending approval page (accessible before approval)
    Route::get('/pending-approval', fn() => view('merchant.pending-approval'))->name('pending-approval');

    // Subscription pages (accessible before subscription is active)
    Route::get('/subscription', [Merchant\SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('/subscription/expired', [Merchant\SubscriptionController::class, 'expired'])->name('subscription.expired');

    // Approved merchant routes
    Route::middleware('merchant.approved')->group(function () {
        Route::get('/dashboard', [Merchant\MerchantDashboardController::class, 'index'])->name('dashboard');

        // Business Profile
        Route::get('/profile', [Merchant\MerchantProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [Merchant\MerchantProfileController::class, 'update'])->name('profile.update');

        // Orders (always accessible, no subscription check)
        Route::get('/orders', [Merchant\MerchantOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', OrderDetail::class)->name('orders.show');

        // Properties - index/show: no subscription needed (delete handled by Livewire)
        Route::get('/properties', PropertyList::class)->name('properties.index');

        // Products - index: no subscription needed (delete handled by Livewire)
        Route::get('/products', ProductList::class)->name('products.index');

        // Services - index: no subscription needed (delete handled by Livewire)
        Route::get('/services', ServiceList::class)->name('services.index');

        // create/store/edit/update: requires active subscription
        Route::middleware('subscription.active')->group(function () {
            // Properties
            Route::get('/properties/create', [Merchant\MerchantPropertyController::class, 'create'])->name('properties.create');
            Route::post('/properties', [Merchant\MerchantPropertyController::class, 'store'])->name('properties.store');
            Route::get('/properties/{property}/edit', [Merchant\MerchantPropertyController::class, 'edit'])->name('properties.edit');
            Route::put('/properties/{property}', [Merchant\MerchantPropertyController::class, 'update'])->name('properties.update');

            // Products
            Route::get('/products/create', [Merchant\MerchantProductController::class, 'create'])->name('products.create');
            Route::post('/products', [Merchant\MerchantProductController::class, 'store'])->name('products.store');
            Route::get('/products/{product}/edit', [Merchant\MerchantProductController::class, 'edit'])->name('products.edit');
            Route::put('/products/{product}', [Merchant\MerchantProductController::class, 'update'])->name('products.update');

            // Services
            Route::get('/services/create', [Merchant\MerchantServiceController::class, 'create'])->name('services.create');
            Route::post('/services', [Merchant\MerchantServiceController::class, 'store'])->name('services.store');
            Route::get('/services/{service}/edit', [Merchant\MerchantServiceController::class, 'edit'])->name('services.edit');
            Route::put('/services/{service}', [Merchant\MerchantServiceController::class, 'update'])->name('services.update');
        });
    });
});

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [Admin\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [Admin\UserManagementController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/suspend', [Admin\UserManagementController::class, 'suspend'])->name('users.suspend');
    Route::patch('/users/{user}/unsuspend', [Admin\UserManagementController::class, 'unsuspend'])->name('users.unsuspend');

    // Merchant Approvals
    Route::get('/merchants', [Admin\MerchantApprovalController::class, 'index'])->name('merchants.index');
    Route::get('/merchants/{merchantProfile}', \App\Livewire\Admin\MerchantDetail::class)->name('merchants.show');

    // Payment Confirmations
    Route::get('/payments', [Admin\PaymentConfirmationController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', \App\Livewire\Admin\PaymentDetail::class)->name('payments.show');

    // Order Management
    Route::get('/orders', [Admin\OrderManagementController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderManagementController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [Admin\OrderManagementController::class, 'updateStatus'])->name('orders.update-status');

    // Inquiries
    Route::get('/inquiries', [Admin\InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [Admin\InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{inquiry}', [Admin\InquiryController::class, 'update'])->name('inquiries.update');

    // Subscription Plans
    Route::resource('subscription-plans', Admin\SubscriptionPlanController::class)->except(['show']);

    // Subscription Management
    Route::get('/subscriptions', \App\Livewire\Admin\SubscriptionManagement::class)->name('subscriptions.index');

    // Site Settings
    Route::get('/settings', \App\Livewire\Admin\SiteSettings::class)->name('settings.index');
});
