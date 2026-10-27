<?php

use App\Models\Post;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Services\UnitAccountService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('deleted unit pendidikan is not resurrected when accessing admin dashboard or user management', function () {
    $admin = User::factory()->create([
        'role' => 'super_admin',
        'email' => 'superadmin@ppru.ac.id',
    ]);

    // Ambil unit yang sudah ada dari database hasil migrasi
    $unit = UnitPendidikan::where('slug', 'smp-islam-terpadu-raudhatul-ulum')->first();
    if (! $unit) {
        $unit = UnitPendidikan::create([
            'name' => 'SMP Islam Terpadu Raudhatul Ulum',
            'short_name' => 'SMPIT RU',
            'slug' => 'smp-islam-terpadu-raudhatul-ulum',
            'category_type' => 'Sekolah IT',
            'order' => 6,
            'is_active' => true,
        ]);
    }

    $unitId = $unit->id;
    expect(UnitPendidikan::where('id', $unitId)->exists())->toBeTrue();

    // Hapus unit
    $unit->delete();
    expect(UnitPendidikan::where('id', $unitId)->exists())->toBeFalse();

    // Akses Admin Dashboard
    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertStatus(200);

    // Pastikan unit yang dihapus TIDAK muncul / dibuat ulang secara otomatis
    expect(UnitPendidikan::where('slug', 'smp-islam-terpadu-raudhatul-ulum')->exists())->toBeFalse();

    // Akses Admin User Management
    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertStatus(200);

    // Pastikan tetap tidak muncul kembali
    expect(UnitPendidikan::where('slug', 'smp-islam-terpadu-raudhatul-ulum')->exists())->toBeFalse();
});

test('deleted warta / posts are not resurrected when viewing unit pages or admin dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'super_admin',
        'email' => 'superadmin@ppru.ac.id',
    ]);

    $unit = UnitPendidikan::where('slug', 'sma-islam-terpadu-raudhatul-ulum')->first();
    if (! $unit) {
        $unit = UnitPendidikan::create([
            'name' => 'SMA Islam Terpadu Raudhatul Ulum',
            'short_name' => 'SMAIT RU',
            'slug' => 'sma-islam-terpadu-raudhatul-ulum',
            'category_type' => 'Sekolah IT',
            'order' => 7,
            'is_active' => true,
        ]);
    }

    // Pastikan ada post untuk unit ini
    Post::updateOrCreate(
        ['slug' => 'kabar-berita-khusus-unit-smait-test'],
        [
            'unit_pendidikan_id' => $unit->id,
            'title' => 'Kabar Berita Khusus Unit SMAIT',
            'content' => '<p>Konten berita asli</p>',
            'type' => 'post',
            'status' => 'publish',
            'author_id' => $admin->id,
            'published_at' => now(),
        ]
    );

    // Hapus seluruh post di unit ini
    Post::where('unit_pendidikan_id', $unit->id)->delete();
    expect(Post::where('unit_pendidikan_id', $unit->id)->count())->toBe(0);

    // Akses halaman detail unit di frontend
    $this->get('/pendidikan/'.$unit->slug)->assertStatus(200);

    // Pastikan post TIDAK otomatis diisi ulang / dibangkitkan
    expect(Post::where('unit_pendidikan_id', $unit->id)->count())->toBe(0);

    // Akses dashboard admin
    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertStatus(200);

    expect(Post::where('unit_pendidikan_id', $unit->id)->count())->toBe(0);
});

test('ensureUnitAccountsExist does not create duplicate units if unit with similar short_name exists', function () {
    $initialCount = UnitPendidikan::where(function ($q) {
        $q->where('short_name', 'like', '%SMP%')
            ->orWhere('name', 'like', '%SMP%');
    })->count();

    expect($initialCount)->toBeGreaterThanOrEqual(1);

    // Jalankan ensureUnitAccountsExist
    UnitAccountService::ensureUnitAccountsExist();

    $newCount = UnitPendidikan::where(function ($q) {
        $q->where('short_name', 'like', '%SMP%')
            ->orWhere('name', 'like', '%SMP%');
    })->count();

    // Tidak boleh bertambah (tidak boleh double)
    expect($newCount)->toBe($initialCount);
});
