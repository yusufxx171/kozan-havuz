<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'icon', 'summary', 'body', 'features', 'image', 'is_featured', 'sort_order', 'is_active', 'seo_title', 'seo_description'])]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, Publishable;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
