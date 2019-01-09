<?php

use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    Asset::register([
        'name' => 'vendor',
        'type' => 'script',
        'path' => 'vendor/script.js'
    ]);
    Asset::register([
        'name' => 'normalize',
        'path' => 'vendor/normalize.css',
        'type' => 'style'
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/script.js',
        'type' => 'script',
        'dependencies' => [
            'jquery',
            'vendor',
        ],
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/style.css',
        'type' => 'style',
        'dependencies' => [
            'normalize',
        ],
    ]);

    // separately enqueued after components script.js to being able
    // to set global config variables before lazysizes is loaded
    if (is_user_logged_in()) {
        Asset::register([
            'name' => 'vendorAuth',
            'type' => 'script',
            'path' => 'vendor/auth.js'
        ]);
        Asset::enqueue([
            'name' => 'Flynt/assets/auth',
            'path' => 'assets/auth.js',
            'type' => 'script',
            'dependencies' => [
                'jquery',
                'vendorAuth',
            ],
        ]);
        Asset::enqueue([
            'name' => 'Flynt/assets/auth',
            'path' => 'assets/auth.css',
            'type' => 'style'
        ]);
    }
});

add_action('admin_enqueue_scripts', function () {
    Asset::register([
        'name' => 'vendorAdmin',
        'type' => 'script',
        'path' => 'vendor/admin.js'
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.js',
        'type' => 'script',
        'dependencies' => [
            'jquery',
            'vendorAdmin',
        ],
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.css',
        'type' => 'style'
    ]);
});
