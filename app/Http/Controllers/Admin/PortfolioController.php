<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePortfolioRequest;
use App\Http\Requests\Admin\UpdatePortfolioRequest;
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
            'portfolios' => Portfolio::query()->latest()->paginate(10),
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
            'portfolios' => Portfolio::query()->latest()->paginate(10),
            'portfolio' => $portfolio,
        ]);
    }

    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image_file');
        $data['image'] = $this->storeImage($request->file('image_file'), $request->string('title')->toString());

        Portfolio::create($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'เพิ่มผลงานเรียบร้อยแล้ว');
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $data = $request->safe()->except('image_file');

        if ($request->hasFile('image_file')) {
            $this->deleteStoredImage($portfolio->image);
            $data['image'] = $this->storeImage($request->file('image_file'), $request->string('title')->toString());
        }

        $portfolio->update($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'อัปเดตผลงานเรียบร้อยแล้ว');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $this->deleteStoredImage($portfolio->image);
        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'ลบผลงานเรียบร้อยแล้ว');
    }

    private function storeImage(UploadedFile $file, string $title): string
    {
        $slug = Str::slug($title) ?: 'portfolio';
        $filename = sprintf(
            '%s-%s-%s.%s',
            $slug,
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
}
