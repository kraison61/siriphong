<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'phone_formatted' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'address_street' => ['nullable', 'string', 'max:255'],
            'address_locality' => ['nullable', 'string', 'max:255'],
            'address_region' => ['nullable', 'string', 'max:255'],
            'address_postal' => ['nullable', 'string', 'max:20'],
            'address_country' => ['nullable', 'string', 'max:10'],
            'taxid' => ['nullable', 'string', 'max:100'],
            'facebook' => ['nullable', 'string', 'max:500'],
            'line' => ['required', 'string', 'max:500'],
            'logo' => ['required', 'string', 'max:500'],
            'logo_width' => ['nullable', 'integer', 'min:1', 'max:5000'],
            'logo_height' => ['nullable', 'integer', 'min:1', 'max:5000'],
            'favicon' => ['nullable', 'string', 'max:500'],
            'hero_image' => ['nullable', 'string', 'max:500'],
            'line_qr' => ['nullable', 'string', 'max:500'],
            'open_hours' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
