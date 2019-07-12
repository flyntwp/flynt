<?php

namespace Flynt\Components\BlockImage;

use Flynt\Api;

Api::registerFields('BlockImage', [
    'layout' => [
        'name' => 'BlockImage',
        'label' => 'Block: Image',
        'sub_fields' => [
            [
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'instructions' => '',
                'max_size' => 4,
                'required' => true,
                'mime_types' => 'jpg,jpeg,png'
            ]
        ]
    ]
]);
