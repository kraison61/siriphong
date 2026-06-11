<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomeController;


// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
// Volt::route('/workshop/buttons', 'workshop-buttons');
// Volt::route('/', 'pages.home')->name('home');
