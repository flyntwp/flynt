<?php

namespace Flynt\Components\HeroTextImage;

use Flynt\Api;

Api::registerFields('HeroTextImage', [
    'layout' => [
        'name' => 'heroTextImage',
        'label' => 'Hero: Text Image',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => 'Content',
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 1,
                'required' => 1
            ],
            [
                'label' => 'Image',
                'instructions' =>
                    'Recommended Height: 1200px. Minimum Height: 600px.',
                'name' => 'image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_height' => 600,
                'mime_types' => 'jpg,jpeg,png,svg',
                'required' => 1
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
                    [
                        'label' => 'Content Alignment',
                        'name' => 'contentAlignment',
                        'type' => 'button_group',
                        'choices' => [
                            'textLeft' =>
                                '<i class=\'dashicons dashicons-editor-alignleft\' title=\'Align content left\'></i>',
                            'textRight' =>
                                '<i class=\'dashicons dashicons-editor-alignright\' title=\'Align content right\'></i>'
                        ],
                        'required' => 1,
                        'default_value' => 'textLeft'
                    ],
                    Api::loadFields('FieldVariables', 'theme')
                ]
            ],
        ]
    ]
]);
