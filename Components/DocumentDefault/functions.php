<?php

namespace Flynt\Components\DocumentDefault;

use Timber\Timber;
use Flynt\Features\Components\Component;
use Flynt\Utils\Asset;

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
      'name' => 'normalize',
      'path' => 'vendor/normalize.css',
      'type' => 'style'
    ]
    ]);

    // separately enqueued after components script.js to being able
    // to set global config variables before lazysizes is loaded
    Asset::enqueue([
        'name' => 'lazysizes',
        'type' => 'script',
        'path' => 'vendor/lazysizes.js'
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
