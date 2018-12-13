<?php

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





