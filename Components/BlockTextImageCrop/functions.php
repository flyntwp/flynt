<?php

namespace Flynt\Components\BlockTextImageCrop;

use Flynt\Api;

Api::registerFields('BlockTextImageCrop', [
    'layout' => [
        'name' => 'blockTextImageCrop',
        'label' => 'Block: Text Image Crop',
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
                'instructions' => 'Recommended Size: Min-Width 720px.',
                'max_size' => 4,
                'min_width' => 720,
                'required' => true,
                'mime_types' => 'gif,jpg,jpeg,png'
            ],
            [
                'label' => 'Content',
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'toolbar' => 'custom',
                'required' => true,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Button Link',
                'name' => 'buttonLink',
                'type' => 'link',
                'instructions' => 'Here you can link to every page you like',
                'return_format' => 'array'
            ]
        ]
    ]
]);
