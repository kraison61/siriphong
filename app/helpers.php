<?php

use App\Support\MediaUrl;

if (! function_exists('media_url')) {
    function media_url(?string $path): ?string
    {
        return MediaUrl::resolve($path);
    }
}
