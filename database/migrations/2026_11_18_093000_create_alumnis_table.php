<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('alumnis')) {
            Schema::create('alumnis', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->nullable()->index();
                $table->string('gender')->default('putra')->index(); // 'putra' atau 'putri'
                $table->string('graduation_year', 10)->index(); // Contoh: '2024', '2020'
                $table->foreignId('unit_pendidikan_id')->nullable()->constrained('unit_pendidikans')->nullOnDelete();
                $table->string('activity')->comment('Aktivitas, profesi, pekerjaan, atau perkuliahan setelah lulus');
                $table->string('photo')->nullable();
                $table->string('phone')->nullable();
                $table->string('social_media')->nullable();
                $table->text('bio')->nullable()->comment('Profil singkat atau pesan untuk almamater');
                $table->integer('order')->default(1);
                $table->boolean('is_published')->default(true)->index();
                $table->timestamps();
            });
        }

        // Migrasikan 12 data alumni yang sebelumnya tersimpan di tabel posts (type = 'alumni')
        try {
            $existingAlumniPosts = DB::table('posts')->where('type', 'alumni')->get();
            $units = DB::table('unit_pendidikans')->get();

            foreach ($existingAlumniPosts as $idx => $post) {
                // Ekstrak tahun kelulusan dari excerpt atau content
                $year = '2020';
                if (preg_match('/(19|20)\d{2}/', $post->excerpt.' '.$post->content, $yearMatch)) {
                    $year = $yearMatch[0];
                }

                // Tentukan segmen putra/putri berdasarkan nama
                $nameLower = strtolower($post->title);
                $isPutri = str_contains($nameLower, 'ustadzah')
                    || str_contains($nameLower, 'fatimah')
                    || str_contains($nameLower, 'aisyah')
                    || str_contains($nameLower, 'nurul')
                    || str_contains($nameLower, 'khadijah')
                    || str_contains($nameLower, 'maryam')
                    || str_contains(strtolower((string) $post->content), 'santriwati');
                $gender = $isPutri ? 'putri' : 'putra';

                // Tentukan unit pendidikan asal jika cocok
                $matchedUnitId = null;
                $excerptAndContent = $post->excerpt.' '.$post->content;
                foreach ($units as $u) {
                    if (! empty($u->short_name) && str_contains($excerptAndContent, $u->short_name)) {
                        $matchedUnitId = $u->id;
                        break;
                    }
                    if (! empty($u->name) && str_contains($excerptAndContent, $u->name)) {
                        $matchedUnitId = $u->id;
                        break;
                    }
                }

                // Ekstrak aktivitas/pekerjaan dari excerpt (biasanya setelah tanda •)
                $activity = $post->excerpt;
                if (str_contains((string) $post->excerpt, '•')) {
                    $parts = explode('•', (string) $post->excerpt);
                    $activity = trim(end($parts));
                }

                DB::table('alumnis')->updateOrInsert(
                    ['slug' => $post->slug ?: Str::slug($post->title)],
                    [
                        'name' => $post->title,
                        'gender' => $gender,
                        'graduation_year' => $year,
                        'unit_pendidikan_id' => $matchedUnitId,
                        'activity' => $activity ?: 'Alumni Pondok Pesantren Raudhatul Ulum Sakatiga',
                        'photo' => $post->featured_image ?: null,
                        'bio' => strip_tags((string) $post->content),
                        'order' => $idx + 1,
                        'is_published' => $post->status === 'publish',
                        'created_at' => $post->created_at ?: now(),
                        'updated_at' => now(),
                    ]
                );
            }
        } catch (Throwable $e) {
            // Abaikan jika migrasi data gagal agar skema tetap terbentuk
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
