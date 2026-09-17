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
        'is_featured',
        'type',
        'featured_image',
        'featured_image_caption',
        'views_count',
        'author_id',
        'author_name',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'is_featured' => 'boolean',
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if (! empty($this->featured_image)) {
            $path = parse_url($this->featured_image, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/campus-ppru-sakatiga.webp';
    }

    public function getPostDateAttribute()
    {
        return $this->published_at ?? $this->created_at;
    }

    public function getReadingTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->content ?? ''));
        $minutes = max(1, (int) ceil($words / 200));

        return "{$minutes} menit baca";
    }

    public function getDisplayAuthorAttribute(): string
    {
        if (! empty($this->author_name)) {
            return $this->author_name;
        }

        if ($this->author && ! empty($this->author->name)) {
            return $this->author->name;
        }

        return 'Humas Pondok Pesantren Raudhatul Ulum Sakatiga';
    }

    public function getPublicUrlAttribute(): string
    {
        if ($this->type === 'page') {
            return match ($this->slug) {
                'sambutan-kepala-sekolah', 'sambutan-ketua-dpd' => route('page.sambutan'),
                'tentang-kami' => route('page.tentang-kami'),
                'visi-dan-misi' => route('page.visi-misi'),
                'sejarah' => route('page.sejarah'),
                'struktur-organisasi', 'struktur-kepengurusan' => route('page.struktur'),
                'privacy-policy' => route('page.privacy-policy'),
                'donasi' => route('donasi'),
                'e-book' => route('download.ebook'),
                'hymne-mars' => route('download.hymne-mars'),
                'logo' => route('download.logo'),
                'hubungi' => route('hubungi'),
                default => url('/'.$this->slug),
            };
        }

        return route('artikel.show', $this->slug);
    }
}
