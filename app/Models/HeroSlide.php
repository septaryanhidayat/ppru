<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory;

    protected $table = 'hero_slides';

    protected $fillable = [
        'title',
        'subtitle',
        'badge',
        'image',
        'btn_primary_text',
        'btn_primary_url',
        'btn_secondary_text',
        'btn_secondary_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getImageUrlAttribute(): string
    {
        if (! empty($this->image)) {
            $path = parse_url($this->image, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/official/drone-raudhatul-ulum.webp';
    }
}
