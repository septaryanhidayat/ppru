<?php

use App\Models\Download;
use App\Models\Dpc;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('home page loads successfully', function () {
    $this->seed();
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Sambutan Kepala Sekolah');
    $response->assertSee('E-Library & Modul Siswa');
});

test('dpc page displays real subdistricts without lorem ipsum', function () {
    $this->seed();
    $response = $this->get('/program-unggulan');
    $response->assertStatus(200);
    $response->assertSee('Program Tahfidz Mutqin 30 Juz');
    $response->assertDontSee('Lorem Ipsum is simply dummy text');
});

test('download ebook returns real file attachment', function () {
    $this->seed();
    $ebook = Download::where('file_path', 'like', '%.pdf')->first();
    expect($ebook)->not->toBeNull();

    $response = $this->get(route('download.file', $ebook->id));
    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
    expect($response->headers->get('content-disposition'))->toContain('attachment');
});

test('download audio returns mp3 attachment', function () {
    $this->seed();
    $audio = Download::where('file_path', 'like', '%.mp3')->first();
    expect($audio)->not->toBeNull();

    $response = $this->get(route('download.file', $audio->id));
    $response->assertStatus(200);
    $response->assertHeader('content-type', 'audio/mpeg');
    expect($response->headers->get('content-disposition'))->toContain('attachment');
});

test('download logo and filename fallbacks return attachment', function () {
    $this->seed();
    $logo = Download::where('title', 'like', '%Logo%')->first();
    expect($logo)->not->toBeNull();

    $response = $this->get(route('download.file', $logo->id));
    $response->assertStatus(200);
    $response->assertHeader('content-type', 'image/png');
    expect($response->headers->get('content-disposition'))->toContain('attachment');

    $thumbResponse = $this->get(route('download.file', 'logo-thumbnail.webp'));
    $thumbResponse->assertStatus(200);
    expect($thumbResponse->headers->get('content-disposition'))->toContain('attachment');
});
