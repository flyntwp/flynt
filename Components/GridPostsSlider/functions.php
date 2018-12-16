<?php

namespace Flynt\Components\GridPostsSlider;

// use Flynt\Utils\Asset;
use Flynt\Features\Components\Component;
use Flynt;

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

    // $data['logo'] = Asset::requireUrl('Components/GridPostsSlider/Assets/arrowSlider.svg');

    return $data;
});

Flynt\registerFields('GridPostsSlider', [
    'layout' => [
        'name' => 'gridPostsSlider',
        'label' => 'Grid: PostsSlider',
        'sub_fields' => [
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
