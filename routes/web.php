<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InspirationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductImageController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/brands/{brandSlug}', [ProductController::class, 'byBrand'])->name('products.brand');

// Categories
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Inspiration
Route::get('/inspiration', [InspirationController::class, 'index'])->name('inspiration.index');
Route::get('/inspiration/{slug}', [InspirationController::class, 'show'])->name('inspiration.show');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('auth.send-reset-link');
Route::get('/verify-reset-token', [AuthController::class, 'showVerifyResetToken'])->name('auth.verify-reset-token');
Route::post('/verify-reset-token', [AuthController::class, 'verifyResetToken'])->name('auth.verify-reset-token.post');
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('auth.reset-password-form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password.post');

// Password Change Routes
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('auth.change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('auth.update-password');
});

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Cart Routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{itemId}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [\App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
});

// Order Routes
Route::middleware('auth')->group(function () {
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/payment/{paymentId}', [\App\Http\Controllers\OrderController::class, 'payment'])->name('orders.payment');
    Route::post('/payment/{paymentId}/process', [\App\Http\Controllers\OrderController::class, 'processPayment'])->name('orders.processPayment');
    Route::post('/orders/{id}/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel');
});

// Staff Routes
Route::prefix('staff')->name('staff.')->middleware(['auth', 'is_staff'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard.alt');
    
    // Orders management
    Route::get('/orders', [\App\Http\Controllers\Staff\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Staff\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/confirm', [\App\Http\Controllers\Staff\OrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{id}/process', [\App\Http\Controllers\Staff\OrderController::class, 'process'])->name('orders.process');
    Route::post('/orders/{id}/ship', [\App\Http\Controllers\Staff\OrderController::class, 'ship'])->name('orders.ship');
    Route::post('/orders/{id}/deliver', [\App\Http\Controllers\Staff\OrderController::class, 'deliver'])->name('orders.deliver');
    Route::post('/orders/{id}/reject', [\App\Http\Controllers\Staff\OrderController::class, 'reject'])->name('orders.reject');
    
    // Inventory management
    Route::get('/inventory', [\App\Http\Controllers\Staff\OrderController::class, 'inventory'])->name('inventory.index');
    Route::get('/inventory/export', [\App\Http\Controllers\Staff\OrderController::class, 'exportInventory'])->name('inventory.export');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.alt');
    
    // Products Admin
    Route::resource('products', AdminProductController::class, [
        'names' => [
            'index' => 'products.index',
            'create' => 'products.create',
            'store' => 'products.store',
            'edit' => 'products.edit',
            'update' => 'products.update',
            'destroy' => 'products.destroy',
        ]
    ]);
    Route::patch('products/{product}/toggle-active', [AdminProductController::class, 'toggleActive'])->name('products.toggleActive');
    Route::patch('products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggleFeatured');
    
    // Product Images
    Route::get('products/{product}/images', [ProductImageController::class, 'edit'])->name('products.images.edit');
    Route::post('products/{product}/images', [ProductImageController::class, 'store'])->name('products.images.store');
    Route::post('products/{product}/images/bulk', [ProductImageController::class, 'bulkUpload'])->name('products.images.bulkUpload');
    Route::put('products/{product}/images/{image}/primary', [ProductImageController::class, 'setPrimary'])->name('products.images.setPrimary');
    Route::delete('products/{product}/images/{image}', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
    
    // Categories Admin
    Route::resource('categories', AdminCategoryController::class, [
        'names' => [
            'index' => 'categories.index',
            'create' => 'categories.create',
            'store' => 'categories.store',
            'edit' => 'categories.edit',
            'update' => 'categories.update',
            'destroy' => 'categories.destroy',
        ]
    ]);
    Route::patch('categories/{category}/toggle-active', [AdminCategoryController::class, 'toggleActive'])->name('categories.toggleActive');
});
