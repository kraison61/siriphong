<?php

use App\Support\MediaUrl;

if (! function_exists('media_url')) {
    function media_url(?string $path): ?string
    {
        return MediaUrl::resolve($path);
    }
}

if (! function_exists('three_motor_url')) {
    function three_motor_url(): string
    {
        return \Illuminate\Support\Facades\Route::has('vacuum.3motor')
            ? route('vacuum.3motor')
            : route('products.category', 'industrial-vacuum');
    }
}
