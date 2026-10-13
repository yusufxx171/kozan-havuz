<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Database\Factories\SliderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['eyebrow', 'title', 'description', 'image', 'primary_button_text', 'primary_button_url', 'secondary_button_text', 'secondary_button_url', 'sort_order', 'is_active'])]
class Slider extends Model
{
    /** @use HasFactory<SliderFactory> */
    use HasFactory, Publishable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
