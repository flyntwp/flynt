<?php

namespace Flynt\Components\HeroImageText;

use Flynt\Api;

Api::registerFields('HeroImageCta', [
    'layout' => [
        'name' => 'heroImageCta',
        'label' => 'Hero: Image Cta',
        'sub_fields' => [
            [
                'label' => 'Images',
                'type' => 'tab',
                'name' => 'accordionImages'
            ],
            [
                'label' => 'Images',
                'type' => 'group',
                'name' => 'images',
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'label' => 'Desktop Image',
                        'name' => 'imageDesktop',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'mime_types' => 'jpg,jpeg',
                        'required' => 1,
                        'instructions' => 'Recommended resolution greater than 2048 x 800 px.'
                    ],
                    [
                        'label' => 'Mobile Image',
                        'name' => 'imageMobile',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'mime_types' => 'jpg,jpeg',
                        'required' => 1,
                        'instructions' => 'Recommended resolution greater than 750 x 800 px.'
                    ]
                ]
            ],
            [
                'label' => 'Content',
                'type' => 'tab',
                'name' => 'accordionContent'
            ],
            [
                'name' => 'contentHtml',
                'label' => 'Content',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
                'instructions' => 'The content overlaying the image. Character Recommendations: Title: 30-100, Content: 80-250.'
            ],
            [
                'label' => 'Button Link',
                'type' => 'link',
                'name' => 'buttonLink',
                'return_format' => 'array'
            ],
            [
                'label' => 'Options',
                'type' => 'tab',
                'name' => 'accordionOptions'
            ],
            [
                'label' => 'Mobile Align Image',
                'name' => 'mobileAlignImage',
                'type' => 'select',
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 0,
                'choices' => [
                    '' => 'Center',
                    'content-image--isLeftAlignMobile' => 'Left',
                    'content-image--isRightAlignMobile' => 'Right',
                ],
                'default_value' => ''
            ],
            [
                'label' => 'Desktop Align Image',
                'name' => 'desktopAlignImage',
                'type' => 'select',
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'ajax' => 0,
                'choices' => [
                    '' => 'Center',
                    'content-image--isLeftAlignDesktop' => 'Left',
                    'content-image--isRightAlignDesktop' => 'Right',
                ],
                'default_value' => 'center'
            ],
        ]
    ]
]);
