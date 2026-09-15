<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
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
        return [
            'parent_id' => ['nullable', 'exists:pages,id'],
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug', 'regex:/^[^\/]+$/'],
            'title' => ['required', 'string', 'max:255'],
            'template' => ['required', Rule::in(['service', 'pricing', 'general', 'portfolio'])],
            'primary_keyword' => ['nullable', 'string', 'max:255'],
            'intro' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'string', 'max:500'],
            'blocks_json' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.regex' => 'Slug ต้องไม่มีเครื่องหมาย / — หน้าลูกให้เลือกหน้าแม่แทน',
        ];
    }
}
