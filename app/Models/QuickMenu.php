<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getIsImageAttribute(): bool
    {
        if (empty($this->icon)) {
            return false;
        }

        return str_starts_with($this->icon, '/')
            || str_starts_with($this->icon, 'http')
            || str_contains($this->icon, '.webp')
            || str_contains($this->icon, '.png')
            || str_contains($this->icon, '.jpg')
            || str_contains($this->icon, '.svg');
    }
}
