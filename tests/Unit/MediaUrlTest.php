<?php

namespace Tests\Unit;

use App\Support\MediaUrl;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MediaUrlTest extends TestCase
{
    public function test_it_returns_full_url_unchanged(): void
    {
        $url = 'https://cdn.example.com/service/test.webp';

        $this->assertSame($url, MediaUrl::resolve($url));
    }

    public function test_it_returns_null_for_empty_path(): void
    {
        $this->assertNull(MediaUrl::resolve(null));
        $this->assertNull(MediaUrl::resolve(''));
    }

    public function test_it_resolves_r2_paths_with_configured_public_url(): void
    {
        $this->configureR2();

        $this->assertSame(
            'https://pub.example.r2.dev/service/test.webp',
            MediaUrl::resolve('service/test.webp')
        );
    }

    public function test_it_strips_storage_prefix_before_resolving(): void
    {
        $this->configureR2();

        $this->assertSame(
            'https://pub.example.r2.dev/portfolio/1.JPG',
            MediaUrl::resolve('storage/portfolio/1.JPG')
        );
    }

    public function test_it_rewrites_services_prefix_to_service(): void
    {
        $this->configureR2();

        $this->assertSame(
            'https://pub.example.r2.dev/service/test.webp',
            MediaUrl::resolve('services/test.webp')
        );
    }

    private function configureR2(): void
    {
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
    }
}
