<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('admin.pages.index', [
            'pages' => Page::query()->with('parent')->orderBy('sort_order')->orderBy('id')->paginate(20),
            'page' => new Page([
                'template' => 'service',
                'sort_order' => 0,
                'is_published' => false,
                'blocks' => [],
            ]),
            'parents' => Page::query()->roots()->orderBy('title')->get(),
        ]);
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.index', [
            'pages' => Page::query()->with('parent')->orderBy('sort_order')->orderBy('id')->paginate(20),
            'page' => $page,
            'parents' => Page::query()->roots()->where('id', '!=', $page->id)->orderBy('title')->get(),
        ]);
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        Page::create($this->payload($request->validated()));

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'เพิ่มหน้าเรียบร้อยแล้ว');
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $page->update($this->payload($request->validated()));

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'อัปเดตหน้าเรียบร้อยแล้ว');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'ลบหน้าเรียบร้อยแล้ว');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        $blocks = $data['blocks_json'] ?? null;
        unset($data['blocks_json']);

        if (is_string($blocks) && filled($blocks)) {
            $decoded = json_decode($blocks, true);
            $data['blocks'] = is_array($decoded) ? $decoded : [];
        } elseif (! isset($data['blocks'])) {
            $data['blocks'] = [];
        }

        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['parent_id'] = $data['parent_id'] ?: null;
        $data['content_updated_at'] = now();

        return $data;
    }
}
