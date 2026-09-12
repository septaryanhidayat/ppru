<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_type',
        'name',
        'agency',
        'whatsapp',
        'purpose',
        'letter_path',
        'ktp_path',
        'npwp_path',
        'status',
        'admin_notes',
        'ip_address',
        'user_agent',
    ];

    /**
     * Human-readable label for service_type
     */
    public function getServiceTypeLabelAttribute(): string
    {
        return match ($this->service_type) {
            'izin_kunjungan' => 'Izin Kunjungan Sekolah',
            'kerja_sama' => 'Permohonan Kerja Sama',
            'sewa_barang' => 'Sewa Barang Milik Sekolah',
            default => ucfirst(str_replace('_', ' ', (string) $this->service_type)),
        };
    }

    /**
     * Human-readable label for status
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Review',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => ucfirst($this->status),
        };
    }

    /**
     * Status color class for Tailwind badges
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
            'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'rejected' => 'bg-rose-100 text-rose-800 border-rose-200',
            'completed' => 'bg-blue-100 text-blue-800 border-blue-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
