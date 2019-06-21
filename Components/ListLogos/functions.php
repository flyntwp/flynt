<?php

namespace Flynt\Components\ListLogos;

use Flynt\Api;

Api::registerFields('ListLogos', [
    'layout' => [
        'name' => 'listLogos',
        'label' => 'List: Logos',
        'sub_fields' => [
            [
                'label' => '',
                'placeholder' => 'Title',
                'name' => 'title',
                'type' => 'text'
            ],
            [
                'label' => '',
                'name' => 'items',
                'type' => 'repeater',
                'collapsed' => '',
                'min' => 1,
                'max' => 8,
                'layout' => 'block',
                'instructions' => '<b>Images:</b> 384 x 216px Minimum - Ratio: 16:9 - Format: PNG',
                'button_label' => 'Add',
                'sub_fields' => [
                    [
                        'label' => '',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                        'wrapper' =>  [
                            'width' => '60'
                        ]
                    ],
                    [
                        'label' => '',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => 384,
                        'min_height' => 216,
                        'max_size' => 2.5,
                        'mime_types' => 'png',
                        'wrapper' =>  [
                            'width' => '40'
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
