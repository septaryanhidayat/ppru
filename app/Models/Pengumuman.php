<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumen';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'file_attachment',
        'status',
        'featured_image',
    ];

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
        return $this->created_at;
    }
}
