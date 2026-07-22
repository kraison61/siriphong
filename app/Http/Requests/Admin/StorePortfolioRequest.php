<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
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
            'category_label' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'brands' => ['nullable', 'string', 'max:255'],
            'image_file' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'year' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'status_label' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer'],
            'is_active' => ['required', 'boolean'],
            'map_coordinates' => ['nullable', 'regex:/^\s*-?\d{1,2}(?:\.\d+)?,\s*-?\d{1,3}(?:\.\d+)?\s*$/'],
        ];
    }
}
