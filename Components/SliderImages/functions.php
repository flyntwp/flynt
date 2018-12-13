<?php

namespace Flynt\Components\SliderImages;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=SliderImages', function ($data) {
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

    return $data;
});
