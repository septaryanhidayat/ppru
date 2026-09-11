<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuickMenuSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SchoolDataSeeder::class);
    }
}
