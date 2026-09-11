<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'type',
        'featured_image',
        'views_count',
        'author_id',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }

    public function scopePosts($query)
    {
        return $query->where('type', 'post');
    }

    public function scopeArticles($query)
    {
        return $query->where('type', 'post');
    }

    public function scopeAgendas($query)
    {
        return $query->where('type', 'agenda');
    }

    public function scopePages($query)
    {
        return $query->where('type', 'page');
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if (! empty($this->featured_image)) {
            $path = parse_url($this->featured_image, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/2024/01/cd1787310f135df61a8832283565af3b.webp';
    }

    public function getPostDateAttribute()
    {
        return $this->published_at ?? $this->created_at;
    }
}
