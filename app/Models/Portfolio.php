<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'category_label',
        'title',
        'description',
        'brands',
        'image',
        'year',
        'duration',
        'status_label',
        'sort_order',
        'is_active',
        'map_coordinates',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function imageUrl(): ?string
    {
        if (! filled($this->image)) {
            return null;
        }

        $path = trim($this->image);

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return '/'.$path;
        }

        return '/storage/'.$path;
    }
}
