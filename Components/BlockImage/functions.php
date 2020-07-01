<?php

namespace Flynt\Components\BlockImage;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'blockImage',
        'label' => 'Block: Image',
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Image', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'instructions' => __('Image-Format: JPG, PNG, GIF.', 'flynt'),
                'required' => 1,
                'mime_types' => 'gif,jpg,jpeg,png'
            ],
            [
                'label' => __('Options', 'flynt'),
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
                        'label' => __('Size', 'flynt'),
                        'name' => 'size',
                        'type' => 'radio',
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'layout' => 'horizontal',
                        'choices' => [
                            'sizeSmall' => __('Small', 'flynt'),
                            'sizeMedium' => __('Medium', 'flynt'),
                            'sizeLarge' => __('Large (Default)', 'flynt)'),
                            'sizeHuge' => __('Huge', 'flynt'),
                            'sizeFull' => __('Full', 'flynt'),
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
