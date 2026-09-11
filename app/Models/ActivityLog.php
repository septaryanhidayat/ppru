<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $action, string $description, string $status = 'info', ?User $user = null): self
    {
        $currentUser = $user ?? auth()->user();

        return self::create([
            'user_id' => $currentUser?->id,
            'user_name' => $currentUser?->name ?? 'Pengunjung / Sistem',
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => $status,
        ]);
    }
}
