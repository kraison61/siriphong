<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $faqs = null;
        $raw = $this->input('faqs_json');

        if (is_string($raw) && trim($raw) !== '') {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $faqs = collect($decoded)
                    ->filter(fn ($item) => is_array($item) && filled($item['question'] ?? null) && filled($item['answer'] ?? null))
                    ->map(fn (array $item) => [
                        'question' => (string) $item['question'],
                        'answer' => (string) $item['answer'],
                    ])
                    ->values()
                    ->all();
            }
        }

        $this->merge([
            'faqs' => $faqs,
            'related_portfolio_id' => $this->filled('related_portfolio_id') ? $this->input('related_portfolio_id') : null,
            'image_width' => $this->filled('image_width') ? $this->input('image_width') : null,
            'image_height' => $this->filled('image_height') ? $this->input('image_height') : null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blogs,slug', 'regex:/^[a-z0-9\-]+$/'],
            'primary_keyword' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'image_width' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'image_height' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'author_name' => ['nullable', 'string', 'max:255'],
            'author_job_title' => ['nullable', 'string', 'max:255'],
            'author_description' => ['nullable', 'string', 'max:500'],
            'faqs_json' => ['nullable', 'string'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['required_with:faqs', 'string', 'max:500'],
            'faqs.*.answer' => ['required_with:faqs', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'related_portfolio_id' => ['nullable', 'integer', 'exists:portfolios,id'],
            'is_published' => ['required', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'content_updated_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.regex' => 'Slug ใช้ได้เฉพาะ a-z, 0-9 และเครื่องหมาย -',
            'faqs.*.question.required_with' => 'FAQ ต้องมีทั้งคำถามและคำตอบ',
            'faqs.*.answer.required_with' => 'FAQ ต้องมีทั้งคำถามและคำตอบ',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $raw = $this->input('faqs_json');
            if (is_string($raw) && trim($raw) !== '' && $this->input('faqs') === null) {
                $validator->errors()->add('faqs_json', 'รูปแบบ JSON ของ FAQ ไม่ถูกต้อง');
            }
        });
    }
}
