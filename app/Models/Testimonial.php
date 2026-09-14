<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'profession',
        'content',
        'photo',
        'status',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if (! empty($this->photo)) {
            $path = parse_url($this->photo, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/avatar-neutral-gray.svg';
    }
}
