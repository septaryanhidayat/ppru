<?php

use App\Models\Post;

test('website can be accessed via primary school domain', function () {
    $response = $this->get('https://robbani.sch.id/');

    $response->assertStatus(200);
});

test('website can be accessed via secondary school domain', function () {
    $response = $this->get('https://smaitplusrobbani.sch.id/');

    $response->assertStatus(200);
});

test('subpages are reachable across domains', function () {
    $response1 = $this->get('https://robbani.sch.id/hubungi');
    $response1->assertStatus(200);

    $response2 = $this->get('https://smaitplusrobbani.sch.id/hubungi');
    $response2->assertStatus(200);
});
