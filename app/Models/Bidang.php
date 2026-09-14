<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'icon',
        'thumbnail',
        'order',
    ];

    public function getThumbnailUrlAttribute(): string
    {
        if (! empty($this->thumbnail)) {
            $path = parse_url($this->thumbnail, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/lab-robbani.jpg';
    }

    public function getIsImageIconAttribute(): bool
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

    public function getIconUrlAttribute(): string
    {
        if ($this->is_image_icon) {
            $path = parse_url($this->icon, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/logo-robbani-emblem.svg';
    }
}
