<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $type = $this->resolveType($request);

        return view('admin.products.index', [
            'type' => $type,
            'products' => Product::query()
                ->with('category')
                ->where('type', $type)
                ->latest()
                ->paginate(10),
            'product' => new Product([
                'type' => $type,
                'is_active' => true,
                'is_featured' => false,
                'price' => 0,
            ]),
            'categories' => Category::query()
                ->where('type', $type)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function edit(Request $request, Product $product): View
    {
        $product->load(['category', 'images']);
        $type = $this->resolveType($request, $product->type);

        return view('admin.products.index', [
            'type' => $type,
            'products' => Product::query()
                ->with('category')
                ->where('type', $type)
                ->latest()
                ->paginate(10),
            'product' => $product,
            'categories' => Category::query()
                ->where('type', $type)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $this->prepareProductData($request);

        $product = Product::create($data);
        $this->storeGalleryImages($product, $request->file('gallery_files', []));

        return redirect()
            ->route('admin.products.index', ['type' => $data['type']])
            ->with('success', $data['type'] === 'service' ? 'เพิ่มบริการเรียบร้อยแล้ว' : 'เพิ่มสินค้าเรียบร้อยแล้ว');
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $this->prepareProductData($request, $product);

        $product->update($data);
        $this->deleteGalleryImages($product, $request->input('delete_gallery_ids', []));
        $this->storeGalleryImages($product, $request->file('gallery_files', []));

        return redirect()
            ->route('admin.products.index', ['type' => $data['type']])
            ->with('success', $data['type'] === 'service' ? 'อัปเดตบริการเรียบร้อยแล้ว' : 'อัปเดตสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $type = $product->type;
        $product->load('images');

        $this->deleteStoredImage($product->image);

        foreach ($product->images as $image) {
            $this->deleteStoredImage($image->path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index', ['type' => $type])
            ->with('success', $type === 'service' ? 'ลบบริการเรียบร้อยแล้ว' : 'ลบสินค้าเรียบร้อยแล้ว');
    }

    /**
     * @return array<string, mixed>
     */
    private function prepareProductData(StoreProductRequest|UpdateProductRequest $request, ?Product $existing = null): array
    {
        $data = $request->safe()->except([
            'image_file',
            'image_icon',
            'gallery_files',
            'delete_gallery_ids',
        ]);

        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name'], $existing);
        $data['category_id'] = filled($data['category_id'] ?? null) ? $data['category_id'] : null;
        $data['sale_price'] = filled($data['sale_price'] ?? null) ? $data['sale_price'] : null;

        if ($request->hasFile('image_file')) {
            if ($existing) {
                $this->deleteStoredImage($existing->image);
            }
            $data['image'] = $this->storeImage($request->file('image_file'), $data['name'], $data['type']);
        } elseif (filled($request->input('image_icon'))) {
            if ($existing) {
                $this->deleteStoredImage($existing->image);
            }
            $data['image'] = $request->string('image_icon')->toString();
        } elseif (! $existing) {
            $data['image'] = null;
        } else {
            unset($data['image']);
        }

        return $data;
    }

    /**
     * @param  array<int, UploadedFile>|UploadedFile|null  $files
     */
    private function storeGalleryImages(Product $product, array|UploadedFile|null $files): void
    {
        if ($files === null) {
            return;
        }

        $files = is_array($files) ? $files : [$files];
        $sortOrder = (int) $product->images()->max('sort_order');

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $sortOrder++;
            $path = $this->storeImage($file, $product->name, $product->type, 'gallery');

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'alt' => $product->name,
                'sort_order' => $sortOrder,
            ]);
        }
    }

    /**
     * @param  array<int, int|string>  $ids
     */
    private function deleteGalleryImages(Product $product, array $ids): void
    {
        if ($ids === []) {
            return;
        }

        $images = $product->images()->whereIn('id', $ids)->get();

        foreach ($images as $image) {
            $this->deleteStoredImage($image->path);
            $image->delete();
        }
    }

    private function storeImage(UploadedFile $file, string $name, string $type, string $folder = 'main'): string
    {
        $slug = Str::slug($name) ?: $type;
        $prefix = $type === 'service' ? 'service' : 'product';
        $filename = sprintf(
            '%s-%s-%s.%s',
            $slug,
            Str::uuid(),
            now()->timestamp,
            strtolower($file->getClientOriginalExtension())
        );

        $path = $file->storeAs($prefix.'/'.$folder, $filename, 'r2');

        if ($path === false) {
            throw ValidationException::withMessages([
                $folder === 'main' ? 'image_file' : 'gallery_files' => 'ไม่สามารถอัปโหลดรูปภาพได้ กรุณาตรวจสอบการตั้งค่า Cloudflare R2',
            ]);
        }

        return $path;
    }

    private function deleteStoredImage(?string $path): void
    {
        if (! filled($path) || filter_var($path, FILTER_VALIDATE_URL) || str_starts_with($path, 'bi ')) {
            return;
        }

        Storage::disk('r2')->delete(ltrim($path, '/'));
    }

    private function resolveType(Request $request, ?string $fallback = 'product'): string
    {
        $type = $request->query('type', $fallback);

        return in_array($type, ['product', 'service'], true) ? $type : 'product';
    }

    private function resolveSlug(?string $slug, string $name, ?Product $existing = null): string
    {
        $base = Str::slug(filled($slug) ? $slug : $name) ?: 'item';
        $candidate = $base;
        $suffix = 1;

        while (
            Product::query()
                ->where('slug', $candidate)
                ->when($existing, fn ($query) => $query->where('id', '!=', $existing->id))
                ->exists()
        ) {
            $candidate = $base.'-'.$suffix;
            $suffix++;
        }

        return $candidate;
    }
}
