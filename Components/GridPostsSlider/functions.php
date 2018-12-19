<?php

namespace Flynt\Components\GridPostsSlider;

use Flynt;
use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=GridPostsSlider', function ($data) {
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

    return $data;
});

Flynt\registerFields('GridPostsSlider', [
    'layout' => [
        'name' => 'gridPostsSlider',
        'label' => 'Grid: Posts Slider',
        'sub_fields' => [
            [
                "label" => "Content HTML",
                "name" => "contentHtml",
                "type" => "wysiwyg",
                "tabs" => "visual,text",
                "toolbar" => "full",
                "media_upload" => false,
                "delay" => true
            ],
            [
                'label' => 'Posts',
                'name' => 'posts',
                'type' => 'relationship',
                'return_format' => 'object',
                'min' => 1,
                'ui' => true,
                'required' => true
            ]
        ]
    ]
]);
