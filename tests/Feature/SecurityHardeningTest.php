<?php

use App\Models\Feedback;
use Illuminate\Support\Facades\RateLimiter;

it('blocks path traversal attempts on legacy uploads route', function () {
    // Attempt path traversal to read .env
    $response = $this->get('/wp-content/uploads/../../.env');
    expect($response->status())->toBeIn([403, 404]);

    // Attempt path traversal with encoded dots
    $response2 = $this->get('/wp-content/uploads/..%2F..%2F.env');
    expect($response2->status())->toBeIn([403, 404]);

    // Attempt requesting unauthorized extension
    $response3 = $this->get('/wp-content/uploads/shell.php');
    expect($response3->status())->toBeIn([403, 404]);
});

it('permanently redirects legacy wp-content image URLs to clean uploads route', function () {
    $response = $this->get('/wp-content/uploads/2025/09/Logo-Web-DPD3.png');
    $response->assertStatus(301);
    expect($response->headers->get('Location'))->toContain('/uploads/2025/09/Logo-Web-DPD3.webp');
});

it('blocks legacy wordpress scanner paths with 404', function () {
    $response1 = $this->get('/wp-admin');
    expect($response1->status())->toBe(404);

    $response2 = $this->get('/wp-login.php');
    expect($response2->status())->toBe(404);

    $response3 = $this->get('/wp-content/plugins/revslider/temp.php');
    expect($response3->status())->toBe(404);
});

it('blocks unauthorized file download extensions and path traversal', function () {
    // Path traversal in download route
    $response = $this->get('/unduh/../../.env');
    expect($response->status())->toBeIn([403, 404]);

    // Non-allowed extension download attempt
    $response2 = $this->get('/unduh/config.php');
    expect($response2->status())->toBeIn([403, 404]);
});

it('attaches security headers to web responses', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    $response->assertHeader('X-Content-Type-Options', 'nosniff');
    $response->assertHeader('X-XSS-Protection', '1; mode=block');
    $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
});

it('rate limits failed login attempts against brute-force attacks', function () {
    RateLimiter::clear('badlogin@example.com|127.0.0.1');

    // 5 failed login attempts
    for ($i = 0; $i < 5; $i++) {
        $this->post('/login', [
            'email' => 'badlogin@example.com',
            'password' => 'wrong-password-'.$i,
        ]);
    }

    // 6th attempt should be blocked by rate limiter
    $response = $this->post('/login', [
        'email' => 'badlogin@example.com',
        'password' => 'another-wrong-password',
    ]);

    $response->assertSessionHasErrors('email');
    $errors = session('errors')->get('email');
    expect($errors[0])->toContain('Terlalu banyak percobaan login gagal');
});

it('traps spam bots using honeypot on contact form without saving to database', function () {
    Feedback::truncate();

    // Bot submission with honeypot field populated
    $response = $this->post('/hubungi', [
        '_hp_security_check' => 'http://spam-casino.com',
        'nama' => 'Casino Bot',
        'email' => 'bot@casino.com',
        'saran_kritik' => 'Visit our poker site at spam-casino.com',
    ]);

    $response->assertRedirect(route('hubungi'));
    // Ensure 0 feedbacks recorded in database
    expect(Feedback::count())->toBe(0);
});

it('sanitizes feedback inputs and strips html tags', function () {
    Feedback::truncate();

    $response = $this->post('/hubungi', [
        'nama' => '<b>Ahmad</b> <script>alert("xss")</script>',
        'email' => 'ahmad@example.com',
        'whatsapp' => '+62 822-8004-1658',
        'saran_kritik' => 'Halo <h1>Ustadz Robbani</h1>, info pendaftaran santri baru.',
    ]);

    $response->assertRedirect(route('hubungi'));
    $saved = Feedback::first();
    expect($saved)->not->toBeNull()
        ->and($saved->name)->toBe('Ahmad alert("xss")')
        ->and($saved->message)->toBe('Halo Ustadz Robbani, info pendaftaran santri baru.')
        ->and($saved->whatsapp)->toBe('+62 822-8004-1658');
});
