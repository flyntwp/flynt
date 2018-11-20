<?php

namespace Flynt\Components\BlockVideoOembed;

use Flynt\Features\Components\Component;
use Flynt\Utils\Oembed;

add_filter('Flynt/addComponentData?name=BlockVideoOembed', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('BlockVideoOembed', [
            [
                'name' => 'lazysizes',
                'type' => 'script',
                'path' => 'vendor/lazysizes.js'
            ]
        ]);
    });

    $data['video'] = Oembed::setSrcAsDataAttribute(
        $data['oembed'],
        [
            'autoplay' => 'true'
        ]
    );

    return $data;
});
