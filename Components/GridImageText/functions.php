<?php

namespace Flynt\Components\GridImageText;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'GridImageText',
        'label' => 'Grid: Image Text',
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
                'delay' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Items',
                'name' => 'items',
                'type' => 'repeater',
                'collapsed' => '',
                'layout' => 'block',
                'button_label' => 'Add',
                'max' => 4,
                'sub_fields' => [
                    [
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'instructions' => '',
                        'max_size' => 4,
                        'required' => 0,
                        'mime_types' => 'gif,jpg,jpeg,png',
                        'wrapper' => [
                            'width' => 40
                        ],
                    ],
                    [
                        'label' => 'Content',
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'media_upload' => 0,
                        'delay' => 1,
                        'required' => 0,
                        'wrapper' => [
                            'class' => 'autosize',
                            'width' => 60
                        ],
                    ]
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
                    FieldVariables\getTheme(),
                    [
                        'label' => 'Show as Card',
                        'name' => 'card',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1
                    ]
                ]
            ]
        ]
    ];
}
