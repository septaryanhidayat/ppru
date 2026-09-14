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
            ['email' => 'admin@robbani.sch.id'],
            [
                'name' => 'Admin SMA IT Plus Robbani',
                'password' => bcrypt('AdminRobbani2026!'),
                'role' => 'admin',
            ]
        );

        $this->call([
            DownloadSeeder::class,
            SchoolDataSeeder::class,
            PpruDataSeeder::class,
            PpruMediaAndNewsSeeder::class,
        ]);
    }
}
