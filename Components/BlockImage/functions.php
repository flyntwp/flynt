<?php

namespace Flynt\Components\BlockImage;

use Flynt\Utils\Component;
use Flynt;

add_filter('Flynt/addComponentData?name=BlockImage', function ($data) {
    Component::enqueueAssets('BlockImage');

    return $data;
});

Flynt\registerFields('BlockImage', [
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
                'mime_types' => 'gif,jpg,jpeg,png'
            ]
        ]
    ]
]);
