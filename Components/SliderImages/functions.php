<?php

namespace Flynt\Components\SliderImages;

use Flynt;
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

Flynt\registerFields('SliderImages', [
    'layout' => [
        'name' => 'sliderImages',
        'label' => 'Slider: Images',
        'sub_fields' => [
            [
                'label' => '',
                'instructions' => '',
                'name' => 'images',
                'type' => 'gallery',
                'min' => 1,
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => 0,
                'min_height' => 0,
                'max_size' => 2.5,
                'mime_types' => 'jpg,jpeg'
            ]
        ]
    ]
]);
