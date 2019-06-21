<?php

namespace Flynt\Components\BlockCountUp;

use Flynt\Api;

Api::registerFields('BlockCountUp', [
    'layout' => [
        'name' => 'BlockCountUp',
        'label' => 'Block: Count Up',
        'sub_fields' => [
            [
                'label' => 'Pre Content HTML',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 1
            ],
            [
                'label' => 'Items',
                'name' => 'items',
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'row',
                'button_label' => 'Add Item',
                'sub_fields' => [
                    [
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'select',
                        'allow_null' => 1,
                        'multiple' => 0,
                        'ui' => 1,
                        'ajax' => 0,
                        'choices' => [
                            'icon-1' => 'Icon 1',
                            'icon-2' => 'Icon 2',
                            'icon-3' => 'Icon 3'
                        ],
                        'default_value' => ''
                    ],
                    [
                        'label' => 'Number',
                        'name' => 'number',
                        'type' => 'number',
                        'required' => 1
                    ],
                    [
                        'label' => 'Subtitle',
                        'name' => 'subtitle',
                        'type' => 'text'
                    ],
                ]
            ],
        ]
    ]
]);
