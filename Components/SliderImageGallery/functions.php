<?php

namespace Flynt\Components\SliderImageGallery;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=SliderImageGallery', function ($data) {
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

    return $data;
});
