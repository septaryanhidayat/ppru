<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaDewan extends Model
{
    use HasFactory;

    protected $table = 'dewan_asatidz';

    protected $fillable = [
        'name',
        'slug',
        'position',
        'fraction',
        'profile_summary',
        'education',
        'photo',
        'order',
    ];

    public function getPhotoUrlAttribute(): string
    {
        if (! empty($this->photo)) {
            $path = parse_url($this->photo, PHP_URL_PATH);

            return '/'.ltrim($path, '/');
        }

        return '/uploads/default-avatar.webp';
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

        $wakilMudir = $all->filter(fn ($d) => str_contains(strtolower($d->position), 'wakil mudir') || str_contains(strtolower($d->position), 'asisten mudir'))->values();

        $kepalaUnit = $all->filter(fn ($d) => (str_contains(strtolower($d->position), 'kepala') || str_contains(strtolower($d->position), 'ketua stit') || str_contains(strtolower($d->position), 'rektor') || str_contains(strtolower($d->position), 'mudir tahfiz')) && $d->id !== $mudir?->id)->values();

        return [
            'pembina' => $pembina ?: (object) ['name' => 'Drs. KH. Karim Kasim', 'position' => 'Ketua Dewan Pembina YAPIRUS'],
            'ketua_yayasan' => $ketuaYayasan ?: (object) ['name' => 'H. Faisal Abdullah, S.T.', 'position' => 'Ketua Umum Pengurus YAPIRUS'],
            'mudir' => $mudir ?: (object) ['name' => "KH. Tol'at Wafa Ahmad, Lc.", 'position' => 'Mudir Pondok Pesantren Raudhatul Ulum'],
            'sekretaris' => $sekretaris ?: (object) ['name' => 'Ustadz H. Ahmad Dailami, S.Pd.I.', 'position' => 'Sekretaris Yayasan YAPIRUS'],
            'bendahara' => $bendahara ?: (object) ['name' => 'H. M. Husin, M.Si.', 'position' => 'Bendahara Yayasan YAPIRUS'],
            'wakil_mudir' => $wakilMudir,
            'kepala_unit' => $kepalaUnit,
            'all' => $all,
        ];
    }
}
