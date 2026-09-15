<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePortfolioRequest;
use App\Http\Requests\Admin\UpdatePortfolioRequest;
use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('admin.portfolios.index', [
            'portfolios' => Portfolio::query()->with('category')->latest()->paginate(10),
            'categories' => $this->portfolioCategories(),
            'portfolio' => new Portfolio([
                'status_label' => 'สำเร็จ',
                'sort_order' => 0,
                'is_active' => true,
            ]),
        ]);
    }

    public function edit(Portfolio $portfolio): View
    {
        return view('admin.portfolios.index', [
            'portfolios' => Portfolio::query()->with('category')->latest()->paginate(10),
            'categories' => $this->portfolioCategories(),
            'portfolio' => $portfolio,
        ]);
    }

    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        $data = $request->safe()->except([
            'image_file',
            'before_image_file',
            'after_image_file',
        ]);

        $title = $request->string('title')->toString();

        if ($request->hasFile('image_file')) {
            $data['image'] = $this->storeImage($request->file('image_file'), $title, 'cover');
        }

        if ($request->hasFile('before_image_file')) {
            $data['before_image'] = $this->storeImage($request->file('before_image_file'), $title, 'before');
        }

        if ($request->hasFile('after_image_file')) {
            $data['after_image'] = $this->storeImage($request->file('after_image_file'), $title, 'after');
        }

        Portfolio::create($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'เพิ่มผลงานเรียบร้อยแล้ว');
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $data = $request->safe()->except([
            'image_file',
            'before_image_file',
            'after_image_file',
        ]);

        $title = $request->string('title')->toString();

        if ($request->hasFile('image_file')) {
            $this->deleteStoredImage($portfolio->image);
            $data['image'] = $this->storeImage($request->file('image_file'), $title, 'cover');
        }

        if ($request->hasFile('before_image_file')) {
            $this->deleteStoredImage($portfolio->before_image);
            $data['before_image'] = $this->storeImage($request->file('before_image_file'), $title, 'before');
        }

        if ($request->hasFile('after_image_file')) {
            $this->deleteStoredImage($portfolio->after_image);
            $data['after_image'] = $this->storeImage($request->file('after_image_file'), $title, 'after');
        }

        $portfolio->update($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'อัปเดตผลงานเรียบร้อยแล้ว');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $this->deleteStoredImage($portfolio->image);
        $this->deleteStoredImage($portfolio->before_image);
        $this->deleteStoredImage($portfolio->after_image);
        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'ลบผลงานเรียบร้อยแล้ว');
    }

    private function storeImage(UploadedFile $file, string $title, string $suffix = 'cover'): string
    {
        $slug = Str::slug($title) ?: 'portfolio';
        $filename = sprintf(
            '%s-%s-%s-%s.%s',
            $slug,
            $suffix,
            Str::uuid(),
            now()->timestamp,
            strtolower($file->getClientOriginalExtension())
        );

        return $file->storeAs('portfolio', $filename, 'r2');
    }

    private function deleteStoredImage(?string $path): void
    {
        if (! filled($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        Storage::disk('r2')->delete(ltrim($path, '/'));
    }

    /**
     * @return \Illuminate\Support\Collection<int, \App\Models\Category>
     */
    private function portfolioCategories()
    {
        return Category::query()
            ->where('type', 'portfolio')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}
