<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpc extends Model
{
    use HasFactory;

    protected $table = 'dpcs';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'head_name',
        'address',
        'thumbnail',
        'order',
    ];

    public function getThumbnailUrlAttribute(): string
    {
        if (! empty($this->thumbnail)) {
            $path = parse_url($this->thumbnail, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/tahfidz-ishum.webp';
    }
}
