<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomeController;


// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::redirect('/admin', '/admin/dashboard');

Volt::route('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
Volt::route('/admin/inquiries', 'admin.inquiries')->name('admin.inquiries');
Volt::route('/admin/users', 'admin.users')->name('admin.users');
Volt::route('/admin/portfolios', 'admin.portfolios')->name('admin.portfolios');
// Volt::route('/workshop/buttons', 'workshop-buttons');
// Volt::route('/', 'pages.home')->name('home');
