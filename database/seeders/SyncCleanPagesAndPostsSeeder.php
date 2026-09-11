<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SyncCleanPagesAndPostsSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SchoolDataSeeder::class);
    }
}
