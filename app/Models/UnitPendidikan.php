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
        'sambutan',
        'visi',
        'misi',
        'head_name',
        'head_photo',
        'phone',
        'email',
        'website_url',
        'thumbnail',
        'hero_image',
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

    public function getHeroImageUrlAttribute(): string
    {
        if (! empty($this->hero_image)) {
            $path = parse_url($this->hero_image, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return $this->thumbnail_url;
    }

    public function getHeadPhotoUrlAttribute(): string
    {
        if (! empty($this->head_photo)) {
            // Never use random activity photos for kepala unit; use neutral gray avatar
            if (str_contains($this->head_photo, '/uploads/official/')
                || str_contains($this->head_photo, 'kbm-santri')
                || str_contains($this->head_photo, 'kegiatan-santri')
                || str_contains($this->head_photo, 'panahan-santri')
                || str_contains($this->head_photo, 'ngaji-sore')
                || str_contains($this->head_photo, 'drone-')) {
                return '/uploads/avatar-neutral-gray.svg';
            }

            $path = parse_url($this->head_photo, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/avatar-neutral-gray.svg';
    }

    public function adminUser()
    {
        return $this->hasOne(User::class, 'unit_pendidikan_id')->where('role', 'admin_unit');
    }

    public function adminUsers()
    {
        return $this->hasMany(User::class, 'unit_pendidikan_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'unit_pendidikan_id');
    }

    public function teachers()
    {
        return $this->hasMany(AnggotaDewan::class, 'unit_pendidikan_id');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'unit_pendidikan_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'unit_pendidikan_id');
    }
}
