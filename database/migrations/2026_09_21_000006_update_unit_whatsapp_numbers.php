<?php

use App\Models\UnitPendidikan;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $unitPhones = [
            'TAKIRU' => '0812-7890-1955',
            'MARU' => '0812-7890-1951',
            'MATSARU' => '0812-7890-1952',
            'MIRU' => '0812-7890-1953',
            'MATQULARU' => '0812-7890-1954',
            'SMPIT RU' => '0812-7890-1956',
            'SMAIT RU' => '0812-7890-1957',
            'IAI NRU' => '0812-7890-1958',
        ];

        foreach ($unitPhones as $shortName => $phone) {
            UnitPendidikan::where('short_name', $shortName)->update(['phone' => $phone]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        UnitPendidikan::query()->update(['phone' => '0812-7890-1950']);
    }
};
