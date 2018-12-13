<?php

Flynt\registerFields('BlockVideoOembed', [
    'layout' => [
        'name' => 'blockVideoOembed',
        'label' => 'Block: Video Oembed',
        'sub_fields' => [
            [
                'name' => 'posterImage',
                'label' => 'Poster Image',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg',
                'instructions' => 'Recommended Size: Min-Width 1200px; Min-Height: 675px; Image-Format: JPG, Aspect Ratio 16/9.',
                'required' => 1
            ],
            [
                'label' => 'Video',
                'name' => 'oembed',
                'type' => 'oembed',
                'required' => 1
            ]
        ]
    ]
]);
