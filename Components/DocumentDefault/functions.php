<?php

namespace Flynt\Components\DocumentDefault;

use Timber\Timber;
use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('DocumentDefault', [
    [
      'name' => 'console-polyfill',
      'type' => 'script',
      'path' => 'vendor/console.js'
    ],
    [
      'name' => 'babel-polyfill',
      'type' => 'script',
      'path' => 'vendor/babel-polyfill.js'
    ],
    [
      'name' => 'document-register-element',
      'type' => 'script',
      'path' => 'vendor/document-register-element.js'
    ],
    [
      'name' => 'picturefill',
      'path' => 'vendor/picturefill.js',
      'type' => 'script'
    ],
    [
      'name' => 'normalize',
      'path' => 'vendor/normalize.css',
      'type' => 'style'
    ]
    ]);
}, 0);

add_filter('Flynt/addComponentData?name=DocumentDefault', function ($data) {
    $context = Timber::get_context();

    $output = [
        'feedTitle' => $context['site']->name . ' ' . __('Feed', 'flynt-starter-theme'),
        'dir' => is_rtl() ? 'rtl' : 'ltr'
    ];

    return array_merge($context, $data, $output);
});
