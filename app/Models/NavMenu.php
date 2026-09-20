<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavMenu extends Model
{
    use HasFactory;

    protected $table = 'nav_menus';

    protected $fillable = [
        'parent_id',
        'name',
        'url',
        'icon',
        'location',
        'target',
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

    public function scopeLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavMenu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(NavMenu::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function getTitleAttribute(): string
    {
        return $this->attributes['name'] ?? '';
    }
}
