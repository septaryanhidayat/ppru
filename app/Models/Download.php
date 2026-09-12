<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_type',
        'file_path',
        'cover_image',
        'file_type',
        'file_size',
        'download_count',
    ];

    protected $casts = [
        'download_count' => 'integer',
    ];
}
