<?php

namespace Flynt\Components\SliderImagesCentered;

use Flynt\Api;

Api::registerFields('SliderImagesCentered', [
    'layout' => [
        'name' => 'sliderImagesCentered',
        'label' => 'Slider: Images Centered',
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
