<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'youtube_url',
        'youtube_id',
        'description',
    ];

    /**
     * Otomatis ambil YouTube ID dari kolom youtube_id atau parsing dari youtube_url jika kosong.
     */
    public function getYoutubeIdAttribute($value): ?string
    {
        if (! empty($value)) {
            return trim($value);
        }

        if (! empty($this->youtube_url)) {
            $url = html_entity_decode((string) $this->youtube_url);
            if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * URL Thumbnail resmi YouTube resolusi tinggi.
     */
    public function getThumbnailUrlAttribute(): string
    {
        $id = $this->youtube_id;
        if ($id) {
            return "https://i.ytimg.com/vi/{$id}/hqdefault.jpg";
        }

        return '/uploads/gedung-smait-ishum.webp';
    }
}
