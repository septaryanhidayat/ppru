<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'youtube_url',
        'youtube_id',
        'description',
        'unit_pendidikan_id',
    ];

    protected static function booted(): void
    {
        static::saving(function (Video $video) {
            if (empty($video->youtube_id) && ! empty($video->youtube_url)) {
                $video->youtube_id = self::extractYoutubeId($video->youtube_url);
            } elseif (! empty($video->youtube_id)) {
                $video->youtube_id = self::extractYoutubeId($video->youtube_id) ?: trim($video->youtube_id);
            }
        });
    }

    /**
     * Ekstraksi 11-karakter YouTube ID dari berbagai format URL:
     * - https://www.youtube.com/watch?v=ID
     * - https://www.youtube.com/live/ID (Live Streaming)
     * - https://www.youtube.com/shorts/ID (Shorts)
     * - https://youtu.be/ID (Short URL)
     * - https://www.youtube.com/embed/ID
     * - Query parameters tambahan (?si=..., &feature=share, dsb)
     */
    public static function extractYoutubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim(html_entity_decode((string) $url));

        // Jika input sudah merupakan 11-karakter ID YouTube
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Regex komprehensif untuk mendeteksi ID YouTube
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?|live|shorts)/|.*[?&]v=)|youtu\.be/)([\w-]{11})%i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        // Fallback dengan parse_url untuk query parameter v
        $parsed = parse_url($url);
        if (! empty($parsed['query'])) {
            parse_str($parsed['query'], $queryParams);
            if (! empty($queryParams['v']) && preg_match('/^[\w-]{11}$/', $queryParams['v'])) {
                return $queryParams['v'];
            }
        }

        // Fallback untuk segment URL terakhir
        if (! empty($parsed['path'])) {
            $segments = explode('/', trim($parsed['path'], '/'));
            $lastSegment = end($segments);
            if ($lastSegment && preg_match('/^[\w-]{11}$/', $lastSegment)) {
                return $lastSegment;
            }
        }

        return null;
    }

    /**
     * Sinkronisasi ID video YouTube yang masih kosong atau belum terisi di database.
     */
    public static function syncMissingYoutubeIds(): int
    {
        $updated = 0;
        $videos = self::where(function ($query) {
            $query->whereNull('youtube_id')
                ->orWhere('youtube_id', '')
                ->orWhereRaw('LENGTH(youtube_id) != 11');
        })->whereNotNull('youtube_url')->get();

        foreach ($videos as $video) {
            $id = self::extractYoutubeId($video->youtube_url);
            if ($id && $id !== $video->getRawOriginal('youtube_id')) {
                $video->youtube_id = $id;
                $video->saveQuietly();
                $updated++;
            }
        }

        return $updated;
    }

    public function unitPendidikan(): BelongsTo
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_pendidikan_id');
    }

    public function scopeForUnit($query, ?int $unitId)
    {
        if (! empty($unitId)) {
            return $query->where('unit_pendidikan_id', $unitId);
        }

        return $query;
    }

    /**
     * Otomatis ambil YouTube ID dari kolom youtube_id atau parsing dari youtube_url jika kosong.
     */
    public function getYoutubeIdAttribute($value): ?string
    {
        if (! empty($value)) {
            $extracted = self::extractYoutubeId($value);
            if ($extracted) {
                return $extracted;
            }
        }

        if (! empty($this->youtube_url)) {
            return self::extractYoutubeId($this->youtube_url);
        }

        return null;
    }

    /**
     * URL Thumbnail resmi YouTube resolusi tinggi (hqdefault).
     */
    public function getThumbnailUrlAttribute(): string
    {
        $id = $this->youtube_id;
        if ($id) {
            return "https://i.ytimg.com/vi/{$id}/hqdefault.jpg";
        }

        return '/uploads/campus-ppru-sakatiga.webp';
    }

    /**
     * URL Embed YouTube yang kompatibel.
     */
    public function getYoutubeEmbedUrlAttribute(): string
    {
        $id = $this->youtube_id;

        return $id ? "https://www.youtube-nocookie.com/embed/{$id}" : '';
    }
}
