<?php

use App\Models\PpdbRegistration;
use App\Models\UnitPendidikan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('ppdb_registrations')) {
            if (! Schema::hasColumn('ppdb_registrations', 'unit_pendidikan_id')) {
                Schema::table('ppdb_registrations', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                    $table->index('unit_pendidikan_id');
                });
            }

            // Backfill existing registrations based on program_type, track, or existing notes
            $units = UnitPendidikan::all();
            $registrations = PpdbRegistration::whereNull('unit_pendidikan_id')->get();

            foreach ($registrations as $reg) {
                $matchedUnitId = null;
                $haystack = strtolower(($reg->program_type ?? '').' '.($reg->track ?? '').' '.($reg->notes ?? ''));

                foreach ($units as $u) {
                    $uName = strtolower($u->name);
                    $uShort = strtolower($u->short_name);
                    $uSlug = strtolower($u->slug);

                    if (! empty($uShort) && str_contains($haystack, $uShort)) {
                        $matchedUnitId = $u->id;
                        break;
                    }
                    if (str_contains($haystack, $uSlug)) {
                        $matchedUnitId = $u->id;
                        break;
                    }
                }

                // If still null, check common abbreviations
                if (! $matchedUnitId) {
                    if (str_contains($haystack, 'takiru') || str_contains($haystack, 'taman kanak') || str_contains($haystack, 'tk')) {
                        $matchedUnitId = 5;
                    } elseif (str_contains($haystack, 'matsaru') || str_contains($haystack, 'tsanawiyah') || str_contains($haystack, 'mts')) {
                        $matchedUnitId = 2;
                    } elseif (str_contains($haystack, 'miru') || str_contains($haystack, 'ibtidaiyah') || str_contains($haystack, 'mi')) {
                        $matchedUnitId = 3;
                    } elseif (str_contains($haystack, 'matqularu') || str_contains($haystack, 'tahfidz')) {
                        $matchedUnitId = 4;
                    } elseif (str_contains($haystack, 'smpit') || str_contains($haystack, 'smp')) {
                        $matchedUnitId = 6;
                    } elseif (str_contains($haystack, 'smait') || str_contains($haystack, 'sma')) {
                        $matchedUnitId = 7;
                    } elseif (str_contains($haystack, 'iai') || str_contains($haystack, 'institut')) {
                        $matchedUnitId = 8;
                    } else {
                        // Default to MARU (id 1)
                        $matchedUnitId = 1;
                    }
                }

                $reg->update(['unit_pendidikan_id' => $matchedUnitId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ppdb_registrations') && Schema::hasColumn('ppdb_registrations', 'unit_pendidikan_id')) {
            Schema::table('ppdb_registrations', function (Blueprint $table) {
                $table->dropColumn('unit_pendidikan_id');
            });
        }
    }
};
