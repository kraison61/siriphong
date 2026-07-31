<?php

namespace Tests\Unit;

use App\Support\StorageUrl;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class StorageUrlTest extends TestCase
{
    public function test_it_returns_full_url_unchanged(): void
    {
        $url = 'https://cdn.example.com/services/test.webp';

        $this->assertSame($url, StorageUrl::resolve($url));
    }

    public function test_it_returns_null_for_empty_path(): void
    {
        $this->assertNull(StorageUrl::resolve(null));
        $this->assertNull(StorageUrl::resolve(''));
    }

    public function test_it_resolves_public_folder_paths_with_asset(): void
    {
        URL::forceRootUrl('https://example.com');
        URL::forceScheme('https');

        $this->assertSame(
            'https://example.com/images/products/test.jpg',
            StorageUrl::resolve('images/products/test.jpg')
        );
    }

    public function test_it_resolves_r2_paths_with_configured_public_url(): void
    {
        Config::set('filesystems.default', 'r2');
        Config::set('filesystems.disks.r2', [
            'driver' => 's3',
            'key' => 'test-key',
            'secret' => 'test-secret',
            'region' => 'auto',
            'bucket' => 'test-bucket',
            'url' => 'https://pub.example.r2.dev',
            'endpoint' => 'https://example.r2.cloudflarestorage.com',
            'use_path_style_endpoint' => true,
            'throw' => false,
        ]);

        $this->assertSame(
            'https://pub.example.r2.dev/services/test.webp',
            StorageUrl::resolve('services/test.webp')
        );
    }

    public function test_it_strips_storage_prefix_before_resolving(): void
    {
        Config::set('filesystems.default', 'r2');
        Config::set('filesystems.disks.r2', [
            'driver' => 's3',
            'key' => 'test-key',
            'secret' => 'test-secret',
            'region' => 'auto',
            'bucket' => 'test-bucket',
            'url' => 'https://pub.example.r2.dev',
            'endpoint' => 'https://example.r2.cloudflarestorage.com',
            'use_path_style_endpoint' => true,
            'throw' => false,
        ]);

        $this->assertSame(
            'https://pub.example.r2.dev/portfolio/1.JPG',
            StorageUrl::resolve('storage/portfolio/1.JPG')
        );
    }

    public function test_it_uses_public_disk_when_default_is_local(): void
    {
        Config::set('filesystems.default', 'local');
        Config::set('filesystems.disks.public.url', 'https://example.com/storage');

        $this->assertSame(
            'https://example.com/storage/services/test.webp',
            StorageUrl::resolve('services/test.webp')
        );
    }
}
