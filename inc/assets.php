<?php

use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    Asset::register([
        'name' => 'console-polyfill',
        'type' => 'script',
        'path' => 'vendor/console.js'
    ]);
    Asset::register([
        'name' => 'babel-polyfill',
        'type' => 'script',
        'path' => 'vendor/babel-polyfill.js'
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
            'console-polyfill',
            'babel-polyfill'
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
    Asset::enqueue([
        'name' => 'lazysizes',
        'type' => 'script',
        'path' => 'vendor/lazysizes.js'
    ]);
    if (is_user_logged_in()) {
        Asset::enqueue([
            'name' => 'Flynt/assets/auth',
            'path' => 'assets/auth.js',
            'type' => 'script',
            'dependencies' => [
                'jquery'
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
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.js',
        'type' => 'script',
        'dependencies' => [
            'jquery'
        ],
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.css',
        'type' => 'style'
    ]);
});
