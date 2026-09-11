<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DpcSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SchoolDataSeeder::class);
    }
}
