<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'avatar', 'unit_pendidikan_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'unit_pendidikan_id' => 'integer',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_pendidikan_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isGlobalAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']) && empty($this->unit_pendidikan_id);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'admin_unit']);
    }

    public function isUnitAdmin(): bool
    {
        return $this->role === 'admin_unit' && ! empty($this->unit_pendidikan_id);
    }

    public function isEditor(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'admin_unit', 'editor']);
    }

    public function getRoleLabelAttribute(): string
    {
        if ($this->isUnitAdmin()) {
            return 'Admin Unit: '.($this->unit?->short_name ?: 'Unit');
        }

        return match ($this->role) {
            'super_admin' => 'Super Administrator',
            'admin' => 'Administrator Pondok',
            'editor' => 'Editor Berita',
            'author' => 'Penulis / Kontributor',
            'admin_unit' => 'Admin Unit',
            default => 'Administrator'
        };
    }
}
