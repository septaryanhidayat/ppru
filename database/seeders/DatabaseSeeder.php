<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'admin@ppru.ac.id'],
            [
                'name' => 'Admin PPRU Sakatiga',
                'password' => bcrypt('AdminPPRU2026!'),
                'role' => 'admin',
            ]
        );

        $this->call([
            DownloadSeeder::class,
            PpruDataSeeder::class,
            PpruMediaAndNewsSeeder::class,
        ]);
    }
}
