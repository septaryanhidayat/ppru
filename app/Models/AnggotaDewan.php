<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaDewan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'position',
        'fraction',
        'profile_summary',
        'education',
        'photo',
        'order',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if (! empty($this->photo)) {
            $path = parse_url($this->photo, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/kepala-sekolah-robbani.jpg';
    }
}
