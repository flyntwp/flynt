<?php

namespace Flynt\Components\ListIcons;

use Flynt\Api;

Api::registerFields('ListIcons', [
    'layout' => [
        'name' => 'ListIcons',
        'label' => 'List: Icons',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => 'Title',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
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
                    Api::loadFields('FieldVariables', 'icon'),
                    [
                        'label' => 'Text content',
                        'name' => 'textContentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'media_upload' => 0,
                        'delay' => 1
                    ],
                    [
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'link',
                    ],
                ]
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
                        'label' => 'Item Alignment',
                        'name' => 'align',
                        'type' => 'button_group',
                        'choices' => [
                            'left' => '<i class=\'dashicons dashicons-align-left\'></i>Left',
                            'centered' => '<i class=\'dashicons dashicons-align-center\'></i>Center'
                        ],
                        'default_value' => 'left'
                    ],
                ]
            ],
        ]
    ]
]);
