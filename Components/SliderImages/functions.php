<?php

namespace Flynt\Components\SliderImages;

use Flynt;

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
