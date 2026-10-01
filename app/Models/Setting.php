<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            static::$memoryCache = null;
        });

        static::deleted(function () {
            static::$memoryCache = null;
        });
    }

    /**
     * In-memory cache for all settings within the request lifecycle.
     *
     * @var array<string, mixed>|null
     */
    protected static ?array $memoryCache = null;

    /**
     * Retrieve all settings with in-memory request-level caching.
     *
     * @return array<string, mixed>
     */
    public static function allCached(): array
    {
        if (static::$memoryCache === null) {
            try {
                static::$memoryCache = static::all()->pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                static::$memoryCache = [];
            }
        }

        return static::$memoryCache;
    }

    public static function get(string $key, $default = null)
    {
        $cached = static::allCached();

        return array_key_exists($key, $cached) ? $cached[$key] : $default;
    }

    public static function set(string $key, $value, string $group = 'general')
    {
        static::$memoryCache = null;

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    public static function clearCache(): void
    {
        static::$memoryCache = null;
    }

    /**
     * Standardize any phone number format to a valid international WhatsApp digits string (default 62...).
     */
    public static function formatWaNumber(?string $phone, string $default = '6281278901950'): string
    {
        $clean = preg_replace('/[^0-9]/', '', (string) ($phone ?: ''));
        if (empty($clean)) {
            $clean = preg_replace('/[^0-9]/', '', $default);
        }

        if (str_starts_with($clean, '0')) {
            $clean = '62'.substr($clean, 1);
        }

        return $clean;
    }

    /**
     * Generate a valid wa.me link with optional pre-filled message text.
     */
    public static function waUrl(?string $phone, ?string $message = null, string $default = '6281278901950'): string
    {
        $digits = static::formatWaNumber($phone, $default);
        $url = 'https://wa.me/'.$digits;

        if ($message !== null && trim($message) !== '') {
            $url .= '?text='.urlencode(trim($message));
        }

        return $url;
    }
}
