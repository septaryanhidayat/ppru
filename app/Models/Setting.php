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
}
