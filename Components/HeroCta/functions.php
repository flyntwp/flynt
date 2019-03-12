<?php

namespace Flynt\Components\HeroCta;

use Flynt\Api;

Api::registerFields('HeroCta', [
    'layout' => [
        'name' => 'heroCta',
        'label' => 'Hero: CTA',
        'sub_fields' => [
            [
                'label' => 'Content',
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Button Link',
                'type' => 'link',
                'name' => 'buttonLink',
                'return_format' => 'array'
            ]
        ]
    ]
]);
