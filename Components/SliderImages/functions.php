<?php

namespace Flynt\Components\SliderImages;

use Flynt\Features\Components\Component;
use Flynt\Utils\Asset;

add_filter('Flynt/addComponentData?name=SliderImages', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('SliderImages', [
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
