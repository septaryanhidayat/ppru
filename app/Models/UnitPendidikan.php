<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPendidikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'slug',
        'category_type',
        'curriculum',
        'badge',
        'description',
        'head_name',
        'phone',
        'email',
        'website_url',
        'thumbnail',
        'logo',
        'icon',
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

    public function getThumbnailUrlAttribute(): string
    {
        if (! empty($this->thumbnail)) {
            $path = parse_url($this->thumbnail, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/logo-ppru-banner.png';
    }

    public function getLogoUrlAttribute(): string
    {
        if (! empty($this->logo)) {
            $path = parse_url($this->logo, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/logo-ppru-emblem.png';
    }

    public function getIconUrlAttribute(): string
    {
        if (! empty($this->icon)) {
            return $this->icon;
        }

        return 'fa-solid fa-graduation-cap';
    }
}
