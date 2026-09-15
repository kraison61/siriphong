<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * สร้างหมวดหมู่ผลงาน (type=portfolio) และผูก category_id ให้ portfolios ที่มีอยู่
 */
class PortfolioCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $categories = [
            ['name' => 'บุคคลทั่วไป', 'slug' => 'personal', 'sort_order' => 1],
            ['name' => 'คาร์แคร์', 'slug' => 'carcare', 'sort_order' => 2],
            ['name' => 'โรงงาน', 'slug' => 'factory', 'sort_order' => 3],
            ['name' => 'บริษัท', 'slug' => 'company', 'sort_order' => 4],
            ['name' => 'คาเฟ่', 'slug' => 'cafe', 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $category['slug']],
                array_merge($category, [
                    'type' => 'portfolio',
                    'updated_at' => $now,
                    'created_at' => $now,
                ])
            );
        }

        $ids = DB::table('categories')
            ->where('type', 'portfolio')
            ->pluck('id', 'slug');

        $portfolios = DB::table('portfolios')->select('id', 'category_label', 'title', 'slug')->get();

        foreach ($portfolios as $portfolio) {
            $mapped = $this->mapCategorySlug(
                (string) ($portfolio->category_label ?? ''),
                (string) ($portfolio->title ?? ''),
                (string) ($portfolio->slug ?? '')
            );

            if (! isset($ids[$mapped])) {
                continue;
            }

            $label = filled($portfolio->category_label)
                ? $this->detailLabel((string) $portfolio->category_label)
                : null;

            DB::table('portfolios')->where('id', $portfolio->id)->update([
                'category_id' => $ids[$mapped],
                'category_label' => $label,
                'updated_at' => $now,
            ]);
        }
    }

    private function mapCategorySlug(string $label, string $title, string $slug): string
    {
        $haystack = Str::lower($label.' '.$title.' '.$slug);

        return match (true) {
            str_contains($haystack, 'คาเฟ่') || str_contains($haystack, 'cafe') || str_contains($haystack, 'cat-cafe') => 'cafe',
            str_contains($haystack, 'คาร์แคร์') || str_contains($haystack, 'carcare') || str_contains($haystack, 'icarwash') || str_contains($haystack, 'car-care') => 'carcare',
            str_contains($haystack, 'โรงงาน') || str_contains($haystack, 'pharma') || str_contains($haystack, 'factory') => 'factory',
            str_contains($haystack, 'บริษัท') || str_contains($haystack, 'company') || str_contains($haystack, 'midori') => 'company',
            str_contains($haystack, 'บุคคล') || str_contains($haystack, 'คอนโด') || str_contains($haystack, 'condo') || str_contains($haystack, 'personal') => 'personal',
            default => 'company',
        };
    }

    private function detailLabel(string $label): ?string
    {
        if (str_contains($label, ' - ')) {
            return trim(explode(' - ', $label, 2)[1]);
        }

        // ถ้า label ตรงกับชื่อหมวดใหญ่แล้ว ไม่ต้องเก็บซ้ำ
        $normalized = trim($label);
        $known = ['บุคคลทั่วไป', 'คาร์แคร์', 'ร้านคาร์แคร์', 'โรงงาน', 'โรงงานยา', 'บริษัท', 'คาเฟ่', 'คาเฟ่แมว'];

        if (in_array($normalized, $known, true)) {
            return null;
        }

        return $normalized;
    }
}
