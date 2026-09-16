<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->filled('slug') ? $this->input('slug') : null,
            'category_id' => $this->filled('category_id') ? $this->input('category_id') : null,
            'related_blog_id' => $this->filled('related_blog_id') ? $this->input('related_blog_id') : null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $portfolioId = $this->route('portfolio')?->id;

        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('type', 'portfolio')],
            'category_label' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('portfolios', 'slug')->ignore($portfolioId), 'regex:/^[a-z0-9\-]+$/'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'fault' => ['nullable', 'string', 'max:255'],
            'symptom' => ['nullable', 'string'],
            'found' => ['nullable', 'string'],
            'fixed' => ['nullable', 'string'],
            'brands' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'before_image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'after_image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'year' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'string', 'max:255'],
            'status_label' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer'],
            'is_active' => ['required', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'related_blog_id' => ['nullable', 'integer', 'exists:blogs,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.regex' => 'Slug ใช้ได้เฉพาะ a-z, 0-9 และเครื่องหมาย -',
        ];
    }
}
