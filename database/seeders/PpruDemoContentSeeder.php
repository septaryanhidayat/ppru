<?php

namespace Database\Seeders;

use App\Services\CmsAutoHealService;
use Illuminate\Database\Seeder;

class PpruDemoContentSeeder extends Seeder
{
    public function run(): void
    {
        CmsAutoHealService::ensureOfficialDemoContentsSeeded();
    }
}
