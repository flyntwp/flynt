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
});
