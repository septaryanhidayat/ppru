<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaDewan extends Model
{
    use HasFactory;

    protected $table = 'dewan_asatidz';

    protected $fillable = [
        'unit_pendidikan_id',
        'name',
        'slug',
        'position',
        'fraction',
        'profile_summary',
        'education',
        'photo',
        'order',
    ];

    public function unit()
    {
        return $this->belongsTo(UnitPendidikan::class, 'unit_pendidikan_id');
    }

    public function getPhotoUrlAttribute(): string
    {
        $neutralGray = '/uploads/avatar-neutral-gray.svg';

        if (empty($this->photo)) {
            return $neutralGray;
        }

        $path = parse_url($this->photo, PHP_URL_PATH);
        $normalized = '/'.ltrim($path, '/');

        // Only Mudir KH. Tol'at Wafa Ahmad has an authentic official portrait
        if (str_contains($normalized, 'kh-tolat-wafa-ahmad') || str_contains($normalized, 'mudir-ppru')) {
            return $normalized;
        }

        // Genuine custom teacher uploads in /uploads/dewan/
        if (str_starts_with($normalized, '/uploads/dewan/')) {
            return $normalized;
        }

        // Strictly reject random student/ceremony/activity/drone/placeholder images for teachers and leaders
        return $neutralGray;
    }

    /**
     * Group organization structure into a visual hierarchy tree for PPRU & YAPIRUS.
     */
    public static function getHierarchyTree(): array
    {
        $all = static::orderBy('order', 'asc')->get();

        $pembina = $all->first(fn ($d) => str_contains(strtolower($d->position), 'pembina') || str_contains(strtolower($d->position), 'pendiri'));
        $ketuaYayasan = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'ketua umum') || str_contains(strtolower($d->position), 'ketua yayasan')) && $d->id !== $pembina?->id);
        $mudir = $all->first(fn ($d) => str_contains(strtolower($d->position), 'mudir pondok') || (str_contains(strtolower($d->position), 'mudir') && ! str_contains(strtolower($d->position), 'wakil') && ! str_contains(strtolower($d->position), 'aulad')));
        $sekretaris = $all->first(fn ($d) => str_contains(strtolower($d->position), 'sekretaris'));
        $bendahara = $all->first(fn ($d) => str_contains(strtolower($d->position), 'bendahara'));

        $wadirPendidikan = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'wakil') || str_contains(strtolower($d->position), 'wadir')) && (str_contains(strtolower($d->position), 'pendidikan') || str_contains(strtolower($d->position), 'pengajaran')));
        $wadirPengasuhan = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'wakil') || str_contains(strtolower($d->position), 'wadir')) && (str_contains(strtolower($d->position), 'pengasuhan') || str_contains(strtolower($d->position), 'santri') || str_contains(strtolower($d->position), 'kesantrian')));
        $wadirSarpras = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'wakil') || str_contains(strtolower($d->position), 'wadir')) && (str_contains(strtolower($d->position), 'sarana') || str_contains(strtolower($d->position), 'sarpras') || str_contains(strtolower($d->position), 'pembangunan')));

        $allWadir = $all->filter(fn ($d) => str_contains(strtolower($d->position), 'wakil mudir') || str_contains(strtolower($d->position), 'asisten mudir'))->values();

        $wakilMudir = collect([
            $wadirPendidikan ?: $allWadir->get(0),
            $wadirPengasuhan ?: $allWadir->get(1),
            $wadirSarpras ?: $allWadir->get(2),
        ])->filter()->values();

        $kepalaUnit = $all->filter(fn ($d) => (str_contains(strtolower($d->position), 'kepala') || str_contains(strtolower($d->position), 'ketua stit') || str_contains(strtolower($d->position), 'rektor') || str_contains(strtolower($d->position), 'mudir tahfiz')) && $d->id !== $mudir?->id)->values();

        return [
            'pembina' => $pembina ?: (object) ['name' => 'Drs. KH. Karim Kasim', 'position' => 'Ketua Dewan Pembina YAPIRUS'],
            'ketua_yayasan' => $ketuaYayasan ?: (object) ['name' => 'H. Faisal Abdullah, S.T.', 'position' => 'Ketua Umum Pengurus YAPIRUS'],
            'mudir' => $mudir ?: (object) ['name' => "KH. Tol'at Wafa Ahmad, Lc.", 'position' => 'Mudir Pondok Pesantren Raudhatul Ulum'],
            'sekretaris' => $sekretaris ?: (object) ['name' => 'Ustadz H. Ahmad Dailami, S.Pd.I.', 'position' => 'Sekretaris Yayasan YAPIRUS'],
            'bendahara' => $bendahara ?: (object) ['name' => 'H. M. Husin, M.Si.', 'position' => 'Bendahara Yayasan YAPIRUS'],
            'wadir_pendidikan' => $wadirPendidikan ?: $wakilMudir->get(0),
            'wadir_pengasuhan' => $wadirPengasuhan ?: $wakilMudir->get(1),
            'wadir_sarpras' => $wadirSarpras ?: $wakilMudir->get(2),
            'wakil_mudir' => $wakilMudir,
            'kepala_unit' => $kepalaUnit,
            'all' => $all,
        ];
    }
}
