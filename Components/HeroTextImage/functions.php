<?php

namespace Flynt\Components\HeroTextImage;

use Flynt\Api;

Api::registerFields('HeroTextImage', [
    'layout' => [
        'name' => 'heroTextImage',
        'label' => 'Hero: Text Image',
        'sub_fields' => [
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
                'instructions' => '',
                'name' => 'image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                // 'min_width' => 0,
                // 'max_width' => 0,
                // 'min_height' => 0,
                // 'max_height' => 0,
                // 'min_size' => 0,
                // 'max_size' => 0,
                'mime_types' => 'jpg,jpeg',
                'required' => 1
            ]
        ]
    ]
]);
