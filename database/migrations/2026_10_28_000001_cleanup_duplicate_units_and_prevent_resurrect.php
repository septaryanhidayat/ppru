<?php

use App\Models\UnitPendidikan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('unit_pendidikans')) {
            return;
        }

        // 1. Gabungkan dan bersihkan Unit Pendidikan yang duplikat (misal SMPITRU dan SMPIT RU, SMAITRU dan SMAIT RU)
        $units = UnitPendidikan::orderBy('id', 'asc')->get();
        $grouped = [];

        foreach ($units as $unit) {
            $cleanShort = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) ($unit->short_name ?: '')));
            $cleanName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $unit->name));

            $groupKey = null;
            if (str_contains($cleanShort, 'smpit') || str_contains($cleanName, 'smpislamterpadu')) {
                $groupKey = 'smpit';
            } elseif (str_contains($cleanShort, 'smait') || str_contains($cleanName, 'smaislamterpadu')) {
                $groupKey = 'smait';
            } elseif (str_contains($cleanShort, 'taki') || str_contains($cleanName, 'tamankanakkanak')) {
                $groupKey = 'takiru';
            } elseif (str_contains($cleanShort, 'matqula') || str_contains($cleanName, 'tahfizhulquran')) {
                $groupKey = 'matqularu';
            } elseif (str_contains($cleanShort, 'matsaru') || str_contains($cleanName, 'tsanawiyah')) {
                $groupKey = 'matsaru';
            } elseif (str_contains($cleanShort, 'miru') || str_contains($cleanName, 'ibtidaiyah')) {
                $groupKey = 'miru';
            } elseif (str_contains($cleanShort, 'maru') || str_contains($cleanName, 'aliyah')) {
                $groupKey = 'maru';
            } elseif (str_contains($cleanShort, 'iainru') || str_contains($cleanName, 'institutfakultas') || str_contains($cleanName, 'nurraudhatululum')) {
                $groupKey = 'iainru';
            } else {
                $groupKey = $cleanShort ?: $cleanName;
            }

            $grouped[$groupKey][] = $unit;
        }

        foreach ($grouped as $key => $unitList) {
            if (count($unitList) > 1) {
                // Pilih unit utama: prioritaskan yang memiliki data terlengkap atau ID terawal
                usort($unitList, function ($a, $b) {
                    $scoreA = (! empty($a->description) ? 2 : 0) + (! empty($a->head_name) ? 1 : 0);
                    $scoreB = (! empty($b->description) ? 2 : 0) + (! empty($b->head_name) ? 1 : 0);
                    if ($scoreA === $scoreB) {
                        return $a->id <=> $b->id;
                    }

                    return $scoreB <=> $scoreA;
                });

                $primary = $unitList[0];
                $duplicates = array_slice($unitList, 1);

                foreach ($duplicates as $dup) {
                    // Reassign semua relasi ke unit utama
                    if (Schema::hasTable('posts') && Schema::hasColumn('posts', 'unit_pendidikan_id')) {
                        DB::table('posts')->where('unit_pendidikan_id', $dup->id)->update(['unit_pendidikan_id' => $primary->id]);
                    }
                    if (Schema::hasTable('videos') && Schema::hasColumn('videos', 'unit_pendidikan_id')) {
                        DB::table('videos')->where('unit_pendidikan_id', $dup->id)->update(['unit_pendidikan_id' => $primary->id]);
                    }
                    if (Schema::hasTable('users') && Schema::hasColumn('users', 'unit_pendidikan_id')) {
                        DB::table('users')->where('unit_pendidikan_id', $dup->id)->update(['unit_pendidikan_id' => $primary->id]);
                    }
                    if (Schema::hasTable('testimonials') && Schema::hasColumn('testimonials', 'unit_pendidikan_id')) {
                        DB::table('testimonials')->where('unit_pendidikan_id', $dup->id)->update(['unit_pendidikan_id' => $primary->id]);
                    }
                    if (Schema::hasTable('dewan_asatidz') && Schema::hasColumn('dewan_asatidz', 'unit_pendidikan_id')) {
                        DB::table('dewan_asatidz')->where('unit_pendidikan_id', $dup->id)->update(['unit_pendidikan_id' => $primary->id]);
                    }
                    if (Schema::hasTable('ppdb_registrations') && Schema::hasColumn('ppdb_registrations', 'unit_pendidikan_id')) {
                        DB::table('ppdb_registrations')->where('unit_pendidikan_id', $dup->id)->update(['unit_pendidikan_id' => $primary->id]);
                    }

                    // Hapus unit duplikat secara permanen
                    $dup->delete();
                }
            }
        }

        // 2. Bersihkan post berita duplikat (jika ada post dengan judul sama persis di unit yang sama)
        if (Schema::hasTable('posts')) {
            $duplicatePosts = DB::table('posts')
                ->select('title', 'unit_pendidikan_id', DB::raw('MIN(id) as keep_id'), DB::raw('COUNT(*) as total'))
                ->where('type', 'post')
                ->groupBy('title', 'unit_pendidikan_id')
                ->having('total', '>', 1)
                ->get();

            foreach ($duplicatePosts as $dp) {
                DB::table('posts')
                    ->where('title', $dp->title)
                    ->where('unit_pendidikan_id', $dp->unit_pendidikan_id)
                    ->where('id', '!=', $dp->keep_id)
                    ->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op on rollback
    }
};
