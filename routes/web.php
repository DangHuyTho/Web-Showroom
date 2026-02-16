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

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
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
