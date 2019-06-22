<?php

use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/main.js',
        'type' => 'script',
    ]);
    Asset::enqueue([
        'name' => 'Flynt/icons',
        'type' => 'script',
        'path' =>
            'https://unpkg.com/feather-icons'
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/main.css',
        'type' => 'style'
    ]);
    Asset::enqueue([
        'name' => 'Flynt/font',
        'type' => 'style',
        'path' =>
            'https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i&display=swap'
    ]);
});

add_action('admin_enqueue_scripts', function () {
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.js',
        'type' => 'script',
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.css',
        'type' => 'style'
    ]);
});
