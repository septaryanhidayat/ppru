<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumnis';

    protected $fillable = [
        'name',
        'slug',
        'gender',
        'graduation_year',
        'unit_pendidikan_id',
        'activity',
        'photo',
        'phone',
        'social_media',
        'bio',
        'order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer',
        'unit_pendidikan_id' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($alumni) {
            if (empty($alumni->slug)) {
                $baseSlug = Str::slug($alumni->name);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug.'-'.$counter;
                    $counter++;
                }
                $alumni->slug = $slug;
            }
        });
    }

    public function unitPendidikan(): BelongsTo
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_pendidikan_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePutra($query)
    {
        return $query->where('gender', 'putra');
    }

    public function scopePutri($query)
    {
        return $query->where('gender', 'putri');
    }

    public function scopeYear($query, ?string $year)
    {
        if (! empty($year) && $year !== 'all') {
            return $query->where('graduation_year', $year);
        }

        return $query;
    }

    public function getPhotoUrlAttribute(): string
    {
        if (! empty($this->photo)) {
            if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
                return $this->photo;
            }

            return url($this->photo);
        }

        return $this->gender === 'putri'
            ? url('/uploads/avatar-neutral-gray.svg')
            : url('/uploads/avatar-neutral-gray.svg');
    }

    public function getGenderLabelAttribute(): string
    {
        return $this->gender === 'putri' ? 'Putri (Santriwati)' : 'Putra (Santriwan)';
    }

    public function getUnitNameAttribute(): string
    {
        return $this->unitPendidikan?->name ?? 'Pondok Pesantren Raudhatul Ulum';
    }
}
