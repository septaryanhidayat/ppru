<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'location',
        'event_date',
        'status',
        'featured_image',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function getFeaturedImageUrlAttribute(): string
    {
        if (! empty($this->featured_image)) {
            $path = parse_url($this->featured_image, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/official/ngaji-sore.webp';
    }

    public function getPostDateAttribute()
    {
        return $this->event_date ?? $this->created_at;
    }
}
