<?php

use App\Models\Feedback;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

test('login page renders and allows user authentication', function () {
    $user = User::create([
        'name' => 'Admin Robbani',
        'email' => 'admin@robbani.sch.id',
        'password' => Hash::make('AdminRobbani2026!'),
    ]);

    $this->get('/login')->assertStatus(200)->assertSee('Panel Administrator');

    // Wrong password fails
    $failResponse = $this->post('/login', [
        'email' => 'admin@robbani.sch.id',
        'password' => 'wrongpassword',
    ]);
    $failResponse->assertSessionHasErrors('email');
    $this->assertGuest();

    // Correct password succeeds
    $successResponse = $this->post('/login', [
        'email' => 'admin@robbani.sch.id',
        'password' => 'AdminRobbani2026!',
    ]);
    $successResponse->assertRedirect('/admin');
    $this->assertAuthenticatedAs($user);
});

test('unauthenticated users are redirected from admin routes', function () {
    $this->get('/admin')->assertRedirect('/login');
    $this->get('/admin/posts')->assertRedirect('/login');
    $this->get('/admin/feedbacks')->assertRedirect('/login');
    $this->get('/admin/settings')->assertRedirect('/login');
});

test('admin can manage posts and convert images to webp on upload', function () {
    $admin = User::create([
        'name' => 'Admin Robbani',
        'email' => 'admin@robbani.sch.id',
        'password' => Hash::make('AdminRobbani2026!'),
    ]);

    $this->actingAs($admin);

    // Dashboard renders
    $this->get('/admin')->assertStatus(200)->assertSee('Dashboard Ringkasan Website');

    // Create a dummy image for upload
    $file = UploadedFile::fake()->image('test_banner.jpg', 600, 400);

    // Create post
    $response = $this->post('/admin/posts', [
        'title' => 'Prestasi Santri Robbani Juara Sains',
        'content' => '<p>Konten artikel pengujian baru.</p>',
        'excerpt' => 'Ringkasan artikel pengujian',
        'status' => 'publish',
        'featured_image' => $file,
    ]);

    $response->assertRedirect('/admin/posts');
    $response->assertSessionHas('success');

    $post = Post::where('title', 'Prestasi Santri Robbani Juara Sains')->first();
    expect($post)->not->toBeNull();
    expect($post->featured_image)->toEndWith('.webp');

    $uploadedPath = public_path(ltrim(parse_url($post->featured_image, PHP_URL_PATH), '/'));
    if (file_exists($uploadedPath)) {
        @unlink($uploadedPath);
    }

    // Edit post
    $this->get("/admin/posts/{$post->id}/edit")->assertStatus(200);

    $updateResponse = $this->put("/admin/posts/{$post->id}", [
        'title' => 'Prestasi Santri Robbani Juara Sains Diperbarui',
        'content' => '<p>Konten yang sudah diedit.</p>',
        'status' => 'publish',
    ]);
    $updateResponse->assertRedirect('/admin/posts');

    $post->refresh();
    expect($post->title)->toBe('Prestasi Santri Robbani Juara Sains Diperbarui');

    // Delete post
    $this->delete("/admin/posts/{$post->id}")->assertRedirect('/admin/posts');
    expect(Post::find($post->id))->toBeNull();
});

test('admin can manage feedbacks and settings', function () {
    $admin = User::create([
        'name' => 'Admin Robbani',
        'email' => 'admin@robbani.sch.id',
        'password' => Hash::make('AdminRobbani2026!'),
    ]);

    $feedback = Feedback::create([
        'name' => 'Wali Santri',
        'email' => 'wali@gmail.com',
        'message' => 'Alhamdulillah pendidikan di Robbani sangat memuaskan.',
        'status' => 'unread',
    ]);

    $this->actingAs($admin);

    // Feedbacks index
    $this->get('/admin/feedbacks')->assertStatus(200)->assertSee('Wali Santri');

    // Mark as read
    $this->post("/admin/feedbacks/{$feedback->id}/read")->assertRedirect();
    expect($feedback->fresh()->status)->toBe('read');

    // Settings page
    $this->get('/admin/settings')->assertStatus(200)->assertSee('Pengaturan Website');

    // Update settings
    $this->post('/admin/settings', [
        'site_name' => 'SMA IT PLUS ROBBANI JUARA',
        'contact_phone' => '08999999999',
    ])->assertRedirect();

    $this->assertDatabaseHas('settings', [
        'key' => 'site_name',
        'value' => 'SMA IT PLUS ROBBANI JUARA',
    ]);
});
