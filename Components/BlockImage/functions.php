<?php

namespace Flynt\Components\BlockImage;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
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
                'instructions' => 'Image-Format: JPG, PNG, GIF.',
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
                    FieldVariables\getTheme(),
                    [
                        'label' => 'Size',
                        'name' => 'size',
                        'type' => 'radio',
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'layout' => 'horizontal',
                        'choices' => [
                            'sizeSmall' => 'Small',
                            'sizeMedium' => 'Medium',
                            'sizeLarge' => 'Large (Default)',
                            'sizeHuge' => 'Huge',
                            'sizeFull' => 'Full',
                        ],
                        'default_value' => 'sizeLarge',
                        'wrapper' =>  [
                            'width' => '100',
                        ],
                    ],
                ]
            ]
        ]
    ];
}
