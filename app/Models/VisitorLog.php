<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'session_id',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'referer',
        'referer_source',
        'url',
        'path',
        'page_title',
        'country',
        'country_code',
        'city',
        'region',
        'is_bot',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
    ];

    public function scopeHumans(Builder $query): Builder
    {
        return $query->where('is_bot', false);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', now()->toDateString());
    }

    public function scopeYesterday(Builder $query): Builder
    {
        return $query->whereDate('created_at', now()->subDay()->toDateString());
    }

    public function scopeRecentDays(Builder $query, int $days = 7): Builder
    {
        return $query->where('created_at', '>=', now()->subDays($days)->startOfDay());
    }
}
