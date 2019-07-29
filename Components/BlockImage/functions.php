<?php

namespace Flynt\Components\BlockImage;

use Flynt\Api;

Api::registerFields('BlockImage', [
    'layout' => [
        'name' => 'BlockImage',
        'label' => 'Block: Image',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'instructions' => '',
                'max_size' => 4,
                'required' => true,
                'mime_types' => 'gif,jpg,jpeg,png'
            ],
            [
                'label' => 'Options',
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    Api::loadFields('FieldVariables', 'theme'),
                    [
                        'label' => 'Size',
                        'name' => 'size',
                        'type' => 'radio',
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'layout' => 'horizontal',
                        'choices' => [
                            'sizeSmall' => 'Small',
                            'sizeMedium' => 'Medium (Default)',
                            'sizeLarge' => 'Large',
                            'sizeHuge' => 'Huge',
                            'sizeFull' => 'Full',
                        ],
                        'default_value' => 'sizeMedium',
                        'wrapper' =>  [
                            'width' => '100',
                        ],
                    ],
                ]
            ]
        ]
    ]
]);
