<?php

namespace Flynt\Components\SliderImageGallery;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=SliderImageGallery', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('SliderImageGallery', [
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
