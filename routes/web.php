<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BlogController as FrontendBlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioCaseController;
use App\Http\Controllers\ProductController as FrontendProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [FrontendProductController::class, 'category'])->name('products.category');
Route::get('/products/{slug}', [FrontendProductController::class, 'show'])->name('products.show');
Route::get('/services/{slug}', [FrontendProductController::class, 'showService'])->name('services.show');

Route::get('/blog', [FrontendBlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [FrontendBlogController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('blogs.show');
Route::get('/portfolio/{slug}', [PortfolioCaseController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('portfolio.cases.show');

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
    Route::resource('pages', AdminPageController::class)->except(['show', 'create']);
    Route::resource('blogs', BlogController::class)->except(['show', 'create']);
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// Legacy Thai slugs → English silo (301)
Route::permanentRedirect('/ซ่อมเครื่องดูดฝุ่นอุตสาหกรรม', '/vacuum-repair');
Route::permanentRedirect('/ซ่อมเครื่องดูดฝุ่นคาร์แคร์', '/vacuum-repair/car-care');
Route::permanentRedirect('/ซ่อมมอเตอร์ไหม้', '/vacuum-repair/burnt-motor');
Route::permanentRedirect('/ราคาซ่อมเครื่องดูดฝุ่น', '/service-rates');
Route::permanentRedirect('/ผลงานซ่อม', '/portfolio');
Route::permanentRedirect('/projects', '/portfolio');

// Dynamic content pages (English silo) — must stay last
Route::get('/{slug}/{childSlug}', [PageController::class, 'showChild'])
    ->where(['slug' => '[a-z0-9\-]+', 'childSlug' => '[a-z0-9\-]+'])
    ->name('pages.show.child');
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('pages.show');
