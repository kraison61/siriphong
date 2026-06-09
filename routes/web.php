<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::get('/', function () {
    return view('index');
});
// Volt::route('/workshop/buttons', 'workshop-buttons');
// Volt::route('/', 'pages.home')->name('home');
