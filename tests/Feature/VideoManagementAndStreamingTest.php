<?php

use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::firstOrCreate(
        ['email' => 'testadmin_video@ppru.ac.id'],
        [
            'name' => 'Admin Video Tester',
            'password' => Hash::make('Password123!'),
            'role' => 'admin',
        ]
    );
});

test('extractYoutubeId accurately extracts id from live streams and all youtube url formats', function () {
    $samples = [
        'https://www.youtube.com/live/BG311kT-yXc' => 'BG311kT-yXc',
        'https://www.youtube.com/live/BG311kT-yXc?si=ab12cd34ef' => 'BG311kT-yXc',
        'https://youtube.com/live/cFXK5Of-IzQ?feature=share' => 'cFXK5Of-IzQ',
        'https://m.youtube.com/live/mRdb_kGhbiQ' => 'mRdb_kGhbiQ',
        'https://www.youtube.com/watch?v=BG311kT-yXc' => 'BG311kT-yXc',
        'https://youtu.be/BG311kT-yXc?si=123' => 'BG311kT-yXc',
        'https://www.youtube.com/shorts/BG311kT-yXc' => 'BG311kT-yXc',
        'https://www.youtube.com/embed/BG311kT-yXc' => 'BG311kT-yXc',
        'BG311kT-yXc' => 'BG311kT-yXc',
    ];

    foreach ($samples as $url => $expectedId) {
        expect(Video::extractYoutubeId($url))->toBe($expectedId);
    }
});

test('video model dynamically resolves youtube id and thumbnail for live stream even if column is empty', function () {
    $video = new Video([
        'title' => 'Pagelaran Seni Teater Akbar Live Streaming',
        'youtube_url' => 'https://www.youtube.com/live/p8B8wKu5o4c?si=xyz123',
        'youtube_id' => '', // Empty like production before fix
    ]);

    expect($video->youtube_id)->toBe('p8B8wKu5o4c');
    expect($video->thumbnail_url)->toBe('https://i.ytimg.com/vi/p8B8wKu5o4c/hqdefault.jpg');
    expect($video->youtube_embed_url)->toBe('https://www.youtube-nocookie.com/embed/p8B8wKu5o4c');
});

test('admin can store video with youtube live stream url and id is extracted', function () {
    $response = $this->actingAs($this->admin)->post('/admin/media/video', [
        'title' => 'Parents Participation Day 2026 SMP IT PPRU Live Stream',
        'youtube_url' => 'https://www.youtube.com/live/BG311kT-yXc?si=shareTest',
        'description' => 'Siaran langsung kegiatan parents day.',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $video = Video::where('title', 'Parents Participation Day 2026 SMP IT PPRU Live Stream')->first();
    expect($video)->not->toBeNull();
    expect($video->youtube_id)->toBe('BG311kT-yXc');
    expect($video->thumbnail_url)->toBe('https://i.ytimg.com/vi/BG311kT-yXc/hqdefault.jpg');
});

test('sync command and model sync automatically heals missing youtube ids in database', function () {
    // Create record with missing raw youtube_id
    $video = Video::create([
        'title' => 'Legacy Live Video Without Extracted ID '.time(),
        'slug' => 'legacy-live-video-'.time(),
        'youtube_url' => 'https://www.youtube.com/live/cFXK5Of-IzQ',
        'youtube_id' => null,
    ]);

    // Force raw column to null to simulate legacy row in DB
    Video::where('id', $video->id)->update(['youtube_id' => null]);
    expect(Video::where('id', $video->id)->value('youtube_id'))->toBeNull();

    // Run artisan sync command
    $this->artisan('video:sync-ids')
        ->expectsOutputToContain('Selesai!')
        ->assertSuccessful();

    // Verify raw column in database is now healed
    expect(Video::where('id', $video->id)->value('youtube_id'))->toBe('cFXK5Of-IzQ');
});

test('frontend video gallery displays live stream video with correct thumbnail and embed', function () {
    $video = Video::create([
        'title' => 'Pagelaran Seni Teater Akbar Zaheeyah Generation Live',
        'slug' => 'pagelaran-seni-teater-akbar-'.time(),
        'youtube_url' => 'https://www.youtube.com/live/mRdb_kGhbiQ',
        'youtube_id' => 'mRdb_kGhbiQ',
        'description' => 'Dokumentasi live streaming teater akbar santriwati.',
    ]);

    $response = $this->get('/video');
    $response->assertOk();
    $response->assertSee('Pagelaran Seni Teater Akbar Zaheeyah Generation Live');
    $response->assertSee('https://i.ytimg.com/vi/mRdb_kGhbiQ/hqdefault.jpg');
    $response->assertSee('playPageVideo');
    $response->assertSee('mRdb_kGhbiQ');
});

test('admin can update video details and id is re-extracted properly', function () {
    $video = Video::create([
        'title' => 'Video Awal Sebelum Diedit',
        'slug' => 'video-awal-'.time(),
        'youtube_url' => 'https://www.youtube.com/watch?v=BG311kT-yXc',
        'youtube_id' => 'BG311kT-yXc',
        'description' => 'Deskripsi lama.',
    ]);

    $response = $this->actingAs($this->admin)->put("/admin/media/video/{$video->id}", [
        'title' => 'Video Setelah Diperbarui Menjadi Live Stream',
        'youtube_url' => 'https://www.youtube.com/live/p8B8wKu5o4c?feature=share',
        'description' => 'Deskripsi baru yang diperbarui.',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Video YouTube berhasil diperbarui.');

    $video->refresh();
    expect($video->title)->toBe('Video Setelah Diperbarui Menjadi Live Stream');
    expect($video->youtube_id)->toBe('p8B8wKu5o4c');
    expect($video->description)->toBe('Deskripsi baru yang diperbarui.');
    expect($video->thumbnail_url)->toBe('https://i.ytimg.com/vi/p8B8wKu5o4c/hqdefault.jpg');
});

test('admin media index displays edit button and edit video modal is present', function () {
    $video = Video::create([
        'title' => 'Video Uji Modal Edit',
        'slug' => 'video-uji-modal-'.time(),
        'youtube_url' => 'https://www.youtube.com/watch?v=cFXK5Of-IzQ',
        'youtube_id' => 'cFXK5Of-IzQ',
    ]);

    $response = $this->actingAs($this->admin)->get('/admin/media');
    $response->assertOk();
    $response->assertSee('Edit Video YouTube');
    $response->assertSee('editVideoModalOpen');
    $response->assertSee('Simpan Perubahan');
});
