
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\SaleController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected Routes
Route::middleware(['auth:web'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Categories Management
    Route::resource('categories', CategoryController::class);
    
    // Customers Management
    Route::resource('customers', CustomerController::class);
    
    // Products Management
    Route::resource('products', ProductController::class);
    Route::get('/products/reports/stock', [ProductController::class, 'stockReport'])->name('products.stock-report');
    
    // Sales Management
    Route::resource('sales', SaleController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');
    Route::get('/sales/reports/export', [SaleController::class, 'salesReport'])->name('sales.report');
    
    // Profile Management
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});
