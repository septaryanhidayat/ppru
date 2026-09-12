<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'living_with',
        'child_order',
        'siblings_count',
        'previous_school',
        'nisn',
        'hobby',
        'favorite_subject',
        'ambition',
        'achievements',
        'phone',
        'father_name',
        'father_birth_place',
        'father_birth_date',
        'father_address',
        'father_education',
        'father_job',
        'father_income',
        'father_phone',
        'mother_name',
        'mother_birth_place',
        'mother_birth_date',
        'mother_address',
        'mother_education',
        'mother_job',
        'mother_income',
        'mother_phone',
        'birth_certificate_path',
        'payment_proof_path',
        'status',
        'academic_year',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'father_birth_date' => 'date',
        'mother_birth_date' => 'date',
        'child_order' => 'integer',
        'siblings_count' => 'integer',
    ];

    public static function generateRegistrationNumber(): string
    {
        $year = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;

        return sprintf('PPDB-%s-%04d', $year, $count);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'accepted' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'verified' => 'bg-blue-100 text-blue-800 border-blue-200',
            'rejected' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-amber-100 text-amber-800 border-amber-200',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'accepted' => 'Diterima',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => 'Menunggu Verifikasi',
        };
    }
}
