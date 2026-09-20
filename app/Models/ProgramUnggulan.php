<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramUnggulan extends Model
{
    use HasFactory;

    protected $table = 'program_unggulans';

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

        return '/uploads/official/drone-raudhatul-ulum.webp';
    }
}
