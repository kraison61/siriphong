<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class StorageUrl
{
    public static function resolve(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        $path = trim($path);

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'assets/') || str_starts_with($path, 'images/')) {
            return asset($path);
        }

        $path = preg_replace('#^storage/#', '', $path);

        return Storage::disk(static::disk())->url($path);
    }

    public static function disk(): string
    {
        $default = config('filesystems.default', 'public');

        return match ($default) {
            'local' => 'public',
            default => $default,
        };
    }
}
