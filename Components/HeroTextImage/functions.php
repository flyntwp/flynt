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
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 1,
                'required' => 1
            ],
            [
                'label' => 'Image',
                'instructions' =>
                    'Recommended Height: 1200px. Minimum Height: 600px. Image Format: JPG.',
                'name' => 'image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_height' => 600,
                'mime_types' => 'jpg,jpeg',
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
            ]
        ]
    ]
]);
