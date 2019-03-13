<?php

namespace Flynt\Components\BlockImageText;

use Flynt\Api;

Api::registerFields('BlockImageText', [
    'layout' => [
        'name' => 'blockImageText',
        'label' => 'Block: Image Text',
        'sub_fields' => [
            [
                'label' => 'Image Position',
                'name' => 'imagePosition',
                'type' => 'button_group',
                'choices' => [
                    'imageLeft' => '<i class=\'dashicons dashicons-align-left\' title=\'Image on the left\'></i>',
                    'imageRight' => '<i class=\'dashicons dashicons-align-right\' title=\'Image on the right\'></i>'
                ]
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
                'name' => 'contentHtml',
                'label' => 'Content',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'toolbar' => 'custom',
                'required' => true,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ]
        ]
    ]
]);
