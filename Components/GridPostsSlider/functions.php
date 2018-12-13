<?php

namespace Flynt\Components\GridPostsSlider;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridPostsSlider', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('GridPostsSlider', [
            [
                'name' => 'slick-carousel',
                'path' => 'vendor/slick.js',
                'type' => 'script'
            ],
            [
                'name' => 'slick-carousel',
                'path' => 'vendor/slick.css',
                'type' => 'style'
            ]
        ]);
    });

    return $data;
});
