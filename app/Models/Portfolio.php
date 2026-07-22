<?php

namespace App\Models;

use App\Support\MediaUrl;
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
        return MediaUrl::resolve($this->image);
    }
}
