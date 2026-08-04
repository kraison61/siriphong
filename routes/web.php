<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as FrontendProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [FrontendProductController::class, 'category'])->name('products.category');
Route::get('/products/{slug}', [FrontendProductController::class, 'show'])->name('products.show');
Route::get('/services/{slug}', [FrontendProductController::class, 'showService'])->name('services.show');
Route::redirect('/admin', '/admin/dashboard');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries');
    Route::resource('users', UserController::class)->except(['show', 'create']);
    Route::resource('portfolios', PortfolioController::class)->except(['show', 'create']);
    Route::resource('categories', CategoryController::class)->except(['show', 'create']);
    Route::resource('products', ProductController::class)->except(['show', 'create']);
});
