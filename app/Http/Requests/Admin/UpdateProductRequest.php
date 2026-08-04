<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'category_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'type' => ['required', Rule::in(['product', 'service'])],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($productId)],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'image_icon' => ['nullable', 'string', 'max:255', 'regex:/^bi\s+bi-[\w-]+$/'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'gallery_files' => ['nullable', 'array'],
            'gallery_files.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'delete_gallery_ids' => ['nullable', 'array'],
            'delete_gallery_ids.*' => ['integer', Rule::exists('product_images', 'id')],
        ];
    }
}
