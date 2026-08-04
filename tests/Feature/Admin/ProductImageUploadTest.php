<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_main_product_image_to_r2(): void
    {
        Storage::fake('r2');

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'เครื่องดูดฝุ่น',
            'slug' => 'industrial-vacuum',
            'type' => 'product',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->post(route('admin.products.store'), [
            'type' => 'product',
            'category_id' => $category->id,
            'name' => 'Test Vacuum',
            'price' => 15000,
            'is_active' => 1,
            'is_featured' => 0,
            'image_file' => UploadedFile::fake()->image('vacuum.jpg'),
        ]);

        $response->assertRedirect(route('admin.products.index', ['type' => 'product']));
        $response->assertSessionHas('success');

        $product = Product::query()->first();
        $this->assertNotNull($product);
        $this->assertStringStartsWith('product/main/', $product->image);
        Storage::disk('r2')->assertExists($product->image);
    }

    public function test_admin_can_upload_service_image_and_gallery_to_r2(): void
    {
        Storage::fake('r2');

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'มอเตอร์',
            'slug' => 'motor',
            'type' => 'service',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->post(route('admin.products.store'), [
            'type' => 'service',
            'category_id' => $category->id,
            'name' => 'Motor Repair',
            'price' => 0,
            'is_active' => 1,
            'is_featured' => 0,
            'image_file' => UploadedFile::fake()->image('motor.webp'),
            'gallery_files' => [
                UploadedFile::fake()->image('gallery-1.jpg'),
                UploadedFile::fake()->image('gallery-2.jpg'),
            ],
        ]);

        $response->assertRedirect(route('admin.products.index', ['type' => 'service']));

        $product = Product::query()->with('images')->first();
        $this->assertNotNull($product);
        $this->assertStringStartsWith('service/main/', $product->image);
        Storage::disk('r2')->assertExists($product->image);
        $this->assertCount(2, $product->images);

        foreach ($product->images as $image) {
            $this->assertStringStartsWith('service/gallery/', $image->path);
            Storage::disk('r2')->assertExists($image->path);
        }
    }

    public function test_admin_can_replace_product_image_on_update(): void
    {
        Storage::fake('r2');

        $user = User::factory()->create();
        $product = Product::create([
            'type' => 'product',
            'name' => 'Old Product',
            'slug' => 'old-product',
            'price' => 1000,
            'is_active' => true,
            'is_featured' => false,
            'image' => UploadedFile::fake()->image('old.jpg')->store('product/main', 'r2'),
        ]);

        $oldPath = $product->image;

        $response = $this->actingAs($user)->put(route('admin.products.update', $product), [
            'type' => 'product',
            'name' => 'Old Product',
            'price' => 1000,
            'is_active' => 1,
            'is_featured' => 0,
            'image_file' => UploadedFile::fake()->image('new.jpg'),
        ]);

        $response->assertRedirect(route('admin.products.index', ['type' => 'product']));

        $product->refresh();
        $this->assertNotSame($oldPath, $product->image);
        Storage::disk('r2')->assertMissing($oldPath);
        Storage::disk('r2')->assertExists($product->image);
    }
}
