<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SyncBidangIconsSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SchoolDataSeeder::class);
    }
}
