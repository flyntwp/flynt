<?php

use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    Asset::enqueue([
        'name' => 'Flynt/assets/vendor',
        'type' => 'script',
        'path' => 'vendor/main.js',
        'dependencies' => [
            'jquery',
        ],
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/main.js',
        'type' => 'script',
        'dependencies' => [
            'jquery',
        ],
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/vendor',
        'path' => 'vendor/main.css',
        'type' => 'style'
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/main.css',
        'type' => 'style',
    ]);
});

add_action('admin_enqueue_scripts', function () {
    Asset::enqueue([
        'name' => 'Flynt/assets/vendorAdmin',
        'type' => 'script',
        'path' => 'vendor/admin.js',
        'dependencies' => [
            'jquery',
        ],
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.js',
        'type' => 'script',
        'dependencies' => [
            'jquery',
        ],
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/vendorAdmin',
        'path' => 'vendor/admin.css',
        'type' => 'style'
    ]);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.css',
        'type' => 'style',
    ]);
});
