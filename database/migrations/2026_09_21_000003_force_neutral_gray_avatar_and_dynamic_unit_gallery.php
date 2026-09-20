<?php

use App\Services\CmsAutoHealService;
use App\Services\UnitDemoContentService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            if (Schema::hasTable('dewan_asatidz')) {
                // 1. Bersihkan seluruh data guru / pengurus yang fotonya acak/santri/placeholder
                DB::table('dewan_asatidz')
                    ->where('slug', '!=', 'kh-tolat-wafa-ahmad-lc')
                    ->where(function ($q) {
                        $q->whereNull('photo')
                            ->orWhere('photo', '')
                            ->orWhere('photo', 'like', '%default-avatar%')
                            ->orWhere('photo', 'like', '%santri%')
                            ->orWhere('photo', 'like', '%kbm%')
                            ->orWhere('photo', 'like', '%ngaji%')
                            ->orWhere('photo', 'like', '%panahan%')
                            ->orWhere('photo', 'like', '%waw19%')
                            ->orWhere('photo', 'like', '%upacara%')
                            ->orWhere('photo', 'like', '%kepala-sekolah%')
                            ->orWhere('photo', 'like', '%kepsek%')
                            ->orWhere('photo', 'like', '%drone%')
                            ->orWhere('photo', 'like', '%logo%');
                    })
                    ->update(['photo' => '/uploads/avatar-neutral-gray.svg']);

                // 2. Pastikan 8 tokoh Yayasan terupdate rapi
                CmsAutoHealService::ensureDewanAsatidzSeeded();
            }

            // 3. Pastikan konten dinamis unit (galeri foto, video, berita, prestasi, ekskul, testimoni) terisi
            UnitDemoContentService::seedAllUnits(false);

            Cache::flush();
        } catch (Throwable $e) {
            // Safe fallback
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
