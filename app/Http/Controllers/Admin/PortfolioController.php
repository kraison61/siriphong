<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePortfolioRequest;
use App\Http\Requests\Admin\UpdatePortfolioRequest;
use App\Models\Category;
use App\Models\Portfolio;
use App\Support\R2Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
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
            $data['image'] = R2Media::store($request->file('image_file'), 'portfolio', $title, 'cover');
        }

        if ($request->hasFile('before_image_file')) {
            $data['before_image'] = R2Media::store($request->file('before_image_file'), 'portfolio', $title, 'before');
        }

        if ($request->hasFile('after_image_file')) {
            $data['after_image'] = R2Media::store($request->file('after_image_file'), 'portfolio', $title, 'after');
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
            R2Media::delete($portfolio->image);
            $data['image'] = R2Media::store($request->file('image_file'), 'portfolio', $title, 'cover');
        }

        if ($request->hasFile('before_image_file')) {
            R2Media::delete($portfolio->before_image);
            $data['before_image'] = R2Media::store($request->file('before_image_file'), 'portfolio', $title, 'before');
        }

        if ($request->hasFile('after_image_file')) {
            R2Media::delete($portfolio->after_image);
            $data['after_image'] = R2Media::store($request->file('after_image_file'), 'portfolio', $title, 'after');
        }

        $portfolio->update($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'อัปเดตผลงานเรียบร้อยแล้ว');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        R2Media::delete($portfolio->image);
        R2Media::delete($portfolio->before_image);
        R2Media::delete($portfolio->after_image);
        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'ลบผลงานเรียบร้อยแล้ว');
    }

    /**
     * @return Collection<int, Category>
     */
    private function portfolioCategories(): Collection
    {
        return Category::query()
            ->where('type', 'portfolio')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
}
