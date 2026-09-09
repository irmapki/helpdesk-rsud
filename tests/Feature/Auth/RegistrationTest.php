<?php

test('registration screen is disabled for public users', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
});
