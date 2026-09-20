<?php

use App\Services\CmsAutoHealService;
use App\Services\UnitDemoContentService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Pulihkan 8 Tokoh Resmi Yayasan (Mudir dengan foto resmi, 7 lainnya default avatar)
        // 2. Bersihkan post & testimoni demo global dari Web Utama (ppru.ac.id)
        CmsAutoHealService::ensureOfficialDemoContentsSeeded();

        // 3. Pastikan seluruh 8 unit pendidikan di-seed dengan konten demo lengkap:
        //    - Dewan Guru: 8 orang per unit (menggunakan avatar netral, tanpa foto santri)
        //    - Video TVRU: 4 video resmi TVRU (@tvrusakatiga) per unit
        //    - Berita / Post: 4 konten per unit
        //    - Prestasi: 4 konten per unit
        //    - Ekstrakurikuler: 4 konten per unit
        //    - Testimoni: 4 konten per unit
        UnitDemoContentService::seedAllUnitsDemo(true);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
