<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $type = $this->resolveType($request);

        return view('admin.categories.index', [
            'type' => $type,
            'categories' => Category::query()
                ->where('type', $type)
                ->orderBy('sort_order')
                ->paginate(10),
            'category' => new Category([
                'type' => $type,
                'sort_order' => 0,
            ]),
        ]);
    }

    public function edit(Request $request, Category $category): View
    {
        $type = $this->resolveType($request, $category->type);

        return view('admin.categories.index', [
            'type' => $type,
            'categories' => Category::query()
                ->where('type', $type)
                ->orderBy('sort_order')
                ->paginate(10),
            'category' => $category,
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name']);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index', ['type' => $data['type']])
            ->with('success', 'เพิ่มหมวดหมู่เรียบร้อยแล้ว');
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->resolveSlug($data['slug'] ?? null, $data['name'], $category);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index', ['type' => $data['type']])
            ->with('success', 'อัปเดตหมวดหมู่เรียบร้อยแล้ว');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $type = $category->type;
        $category->delete();

        return redirect()
            ->route('admin.categories.index', ['type' => $type])
            ->with('success', 'ลบหมวดหมู่เรียบร้อยแล้ว');
    }

    private function resolveType(Request $request, ?string $fallback = 'product'): string
    {
        $type = $request->query('type', $fallback);

        return in_array($type, ['product', 'service'], true) ? $type : 'product';
    }

    private function resolveSlug(?string $slug, string $name, ?Category $existing = null): string
    {
        $base = Str::slug(filled($slug) ? $slug : $name) ?: 'category';
        $candidate = $base;
        $suffix = 1;

        while (
            Category::query()
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
