<?php

test('website can be accessed via primary domain', function () {
    $response = $this->get('https://ppru.ac.id/');

    $response->assertStatus(200);
});

test('website can be accessed via www domain', function () {
    $response = $this->get('https://www.ppru.ac.id/');

    $response->assertStatus(200);
});

test('subpages are reachable across domains', function () {
    $response1 = $this->get('https://ppru.ac.id/hubungi');
    $response1->assertStatus(200);

    $response2 = $this->get('https://www.ppru.ac.id/hubungi');
    $response2->assertStatus(200);
});
