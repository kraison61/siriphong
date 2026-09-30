<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class R2Media
{
    public static function store(
        UploadedFile $file,
        string $directory,
        string $name,
        ?string $suffix = null,
        ?string $input = null,
    ): string {
        $slug = Str::slug($name) ?: Str::slug($directory) ?: 'file';
        $parts = array_filter([$slug, $suffix, (string) Str::uuid(), (string) now()->timestamp]);
        $filename = implode('-', $parts).'.'.strtolower($file->getClientOriginalExtension());

        $path = $file->storeAs($directory, $filename, 'r2');

        if ($path === false) {
            throw ValidationException::withMessages([
                $input ?? 'image_file' => 'ไม่สามารถอัปโหลดรูปภาพได้ กรุณาตรวจสอบการตั้งค่า Cloudflare R2',
            ]);
        }

        return $path;
    }

    public static function delete(?string $path): void
    {
        if (! filled($path) || filter_var($path, FILTER_VALIDATE_URL) || str_starts_with($path, 'bi ')) {
            return;
        }

        Storage::disk('r2')->delete(ltrim($path, '/'));
    }
}
