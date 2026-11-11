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

        // 1. DEWAN PEMBINA YAPIRUS
        $pembinaKetua = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'ketua dewan pembina') || str_contains(strtolower($d->position), 'ketua pembina')));
        if (! $pembinaKetua) {
            $pembinaKetua = $all->first(fn ($d) => str_contains(strtolower($d->position), 'pembina') && ! str_contains(strtolower($d->position), 'anggota'));
        }
        $pembinaAnggota = $all->filter(fn ($d) => (
            str_contains(strtolower($d->position), 'anggota dewan pembina')
            || (str_contains(strtolower($d->position), 'pembina') && $d->id !== $pembinaKetua?->id)
            || (str_contains(strtolower($d->fraction ?? ''), 'pembina') && $d->id !== $pembinaKetua?->id)
        ))->values();

        // 2. PENGURUS HARIAN YAPIRUS
        $harianKetua = $all->first(fn ($d) => (
            str_contains(strtolower($d->position), 'ketua dewan harian')
            || str_contains(strtolower($d->position), 'ketua harian')
            || str_contains(strtolower($d->position), 'ketua umum')
            || str_contains(strtolower($d->position), 'ketua yayasan')
        ));
        $sekretaris1 = $all->first(fn ($d) => str_contains(strtolower($d->position), 'sekretaris') && ! str_contains(strtolower($d->position), 'wakil'));
        $sekretaris2 = $all->first(fn ($d) => str_contains(strtolower($d->position), 'wakil sekretaris'));
        $bendahara1 = $all->first(fn ($d) => str_contains(strtolower($d->position), 'bendahara') && ! str_contains(strtolower($d->position), 'wakil'));
        $bendahara2 = $all->first(fn ($d) => str_contains(strtolower($d->position), 'wakil bendahara'));

        // 3. DEWAN PENGAWAS
        $pengawasKetua = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'ketua dewan pengawas') || str_contains(strtolower($d->position), 'ketua pengawas')));
        if (! $pengawasKetua) {
            $pengawasKetua = $all->first(fn ($d) => str_contains(strtolower($d->position), 'pengawas') && ! str_contains(strtolower($d->position), 'anggota'));
        }
        $pengawasAnggota = $all->filter(fn ($d) => (
            str_contains(strtolower($d->position), 'anggota dewan pengawas')
            || (str_contains(strtolower($d->position), 'pengawas') && $d->id !== $pengawasKetua?->id)
            || (str_contains(strtolower($d->fraction ?? ''), 'pengawas') && $d->id !== $pengawasKetua?->id)
        ))->values();

        // 4. PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD)
        $mudir = $all->first(fn ($d) => (
            (str_contains(strtolower($d->position), 'mudir pondok') || str_contains(strtolower($d->position), "mudir ma'had") || str_contains(strtolower($d->position), 'mudir pesantren'))
            && ! str_contains(strtolower($d->position), 'wakil')
            && ! str_contains(strtolower($d->position), 'naib')
        ));
        if (! $mudir) {
            $mudir = $all->first(fn ($d) => (
                str_contains(strtolower($d->position), 'mudir')
                && ! str_contains(strtolower($d->position), 'wakil')
                && ! str_contains(strtolower($d->position), 'naib')
                && ! str_contains(strtolower($d->position), 'madrasah')
                && ! str_contains(strtolower($d->position), 'sekolah')
            ));
        }

        $naibahMudir = $all->first(fn ($d) => (
            str_contains(strtolower($d->position), 'naibah')
            || (str_contains(strtolower($d->position), 'wakil mudir') && str_contains(strtolower($d->name), 'maila'))
        ));

        $naibMudir = $all->first(fn ($d) => (
            (str_contains(strtolower($d->position), 'naib mudir') || str_contains(strtolower($d->position), 'wakil mudir'))
            && $d->id !== $naibahMudir?->id
        ));

        $wadirPendidikan = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'wakil') || str_contains(strtolower($d->position), 'wadir')) && (str_contains(strtolower($d->position), 'pendidikan') || str_contains(strtolower($d->position), 'pengajaran')));
        $wadirPengasuhan = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'wakil') || str_contains(strtolower($d->position), 'wadir')) && (str_contains(strtolower($d->position), 'pengasuhan') || str_contains(strtolower($d->position), 'santri') || str_contains(strtolower($d->position), 'kesantrian')));
        $wadirSarpras = $all->first(fn ($d) => (str_contains(strtolower($d->position), 'wakil') || str_contains(strtolower($d->position), 'wadir')) && (str_contains(strtolower($d->position), 'sarana') || str_contains(strtolower($d->position), 'sarpras') || str_contains(strtolower($d->position), 'pembangunan')));

        $allWadir = $all->filter(fn ($d) => str_contains(strtolower($d->position), 'wakil mudir') || str_contains(strtolower($d->position), 'asisten mudir') || str_contains(strtolower($d->position), 'naib'))->values();

        $wakilMudir = collect([
            $naibahMudir ?: ($wadirPendidikan ?: $allWadir->get(0)),
            $naibMudir ?: ($wadirPengasuhan ?: $allWadir->get(1)),
            $wadirSarpras ?: $allWadir->get(2),
        ])->filter()->values();

        $kepalaUnit = $all->filter(fn ($d) => (str_contains(strtolower($d->position), 'kepala') || str_contains(strtolower($d->position), 'ketua stit') || str_contains(strtolower($d->position), 'rektor') || str_contains(strtolower($d->position), 'mudir tahfiz')) && $d->id !== $mudir?->id)->values();

        return [
            'pembina_ketua' => $pembinaKetua,
            'pembina_anggota' => $pembinaAnggota,
            'harian_ketua' => $harianKetua,
            'sekretaris_1' => $sekretaris1,
            'sekretaris_2' => $sekretaris2,
            'bendahara_1' => $bendahara1,
            'bendahara_2' => $bendahara2,
            'pengawas_ketua' => $pengawasKetua,
            'pengawas_anggota' => $pengawasAnggota,
            'mudir' => $mudir,
            'naibah_mudir' => $naibahMudir,
            'naib_mudir' => $naibMudir,

            // Legacy keys
            'pembina' => $pembinaKetua,
            'ketua_yayasan' => $harianKetua,
            'sekretaris' => $sekretaris1,
            'bendahara' => $bendahara1,
            'wadir_pendidikan' => $wadirPendidikan ?: $wakilMudir->get(0),
            'wadir_pengasuhan' => $wadirPengasuhan ?: $wakilMudir->get(1),
            'wadir_sarpras' => $wadirSarpras ?: $wakilMudir->get(2),
            'wakil_mudir' => $wakilMudir,
            'kepala_unit' => $kepalaUnit,
            'all' => $all,
        ];
    }
}
