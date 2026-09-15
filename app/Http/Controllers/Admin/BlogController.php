<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('admin.blogs.index', [
            'blogs' => Blog::query()->latest()->paginate(10),
            'blog' => new Blog([
                'is_published' => false,
                'sort_order' => 0,
            ]),
        ]);
    }

    public function edit(Blog $blog): View
    {
        return view('admin.blogs.index', [
            'blogs' => Blog::query()->latest()->paginate(10),
            'blog' => $blog,
        ]);
    }

    public function store(StoreBlogRequest $request): RedirectResponse
    {
        $data = $this->payload($request->safe()->except(['image_file', 'faqs_json']));

        if ($request->hasFile('image_file')) {
            $data['image'] = $this->storeImage($request->file('image_file'), $request->string('title')->toString());
        }

        Blog::create($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'เพิ่มบทความเรียบร้อยแล้ว');
    }

    public function update(UpdateBlogRequest $request, Blog $blog): RedirectResponse
    {
        $data = $this->payload($request->safe()->except(['image_file', 'faqs_json']));

        if ($request->hasFile('image_file')) {
            $this->deleteStoredImage($blog->image);
            $data['image'] = $this->storeImage($request->file('image_file'), $request->string('title')->toString());
        }

        $blog->update($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'อัปเดตบทความเรียบร้อยแล้ว');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        $this->deleteStoredImage($blog->image);
        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'ลบบทความเรียบร้อยแล้ว');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function payload(array $data): array
    {
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['published_at'] = $data['published_at'] ?? null;
        $data['content_updated_at'] = $data['content_updated_at'] ?? null;
        $data['related_portfolio_id'] = $data['related_portfolio_id'] ?? null;
        $data['faqs'] = $data['faqs'] ?? null;

        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (! $data['is_published']) {
            $data['published_at'] = $data['published_at'] ?: null;
        }

        if ($data['is_published'] && empty($data['content_updated_at'])) {
            $data['content_updated_at'] = $data['published_at'] ?? now();
        }

        unset($data['faqs_json']);

        return $data;
    }

    private function storeImage(UploadedFile $file, string $title): string
    {
        $slug = Str::slug($title) ?: 'blog';
        $filename = sprintf(
            '%s-%s-%s.%s',
            $slug,
            Str::uuid(),
            now()->timestamp,
            strtolower($file->getClientOriginalExtension())
        );

        return $file->storeAs('blog', $filename, 'r2');
    }

    private function deleteStoredImage(?string $path): void
    {
        if (! filled($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        Storage::disk('r2')->delete(ltrim($path, '/'));
    }
}
