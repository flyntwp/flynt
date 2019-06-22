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
                        'instructions' => 'Recommended resolution greater than 750 x 800 px.'
                    ]
                ]
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
                    'content-image--isCenterTopAlignMobile' => 'Center Top',
                    'content-image--isCenterCenterAlignMobile' => 'Center Center',
                    'content-image--isCenterBottomAlignMobile' => 'Center Bottom',
                    'content-image--isLeftTopAlignMobile' => 'Left Top',
                    'content-image--isLeftCenterAlignMobile' => 'Left Center',
                    'content-image--isLeftBottomAlignMobile' => 'Left Bottom',
                    'content-image--isRightTopAlignMobile' => 'Right Top',
                    'content-image--isRightCenterAlignMobile' => 'Right Center',
                    'content-image--isRightBottomAlignMobile' => 'Right Bottom',
                ],
                'default_value' => 'content-image--isCenterCenterAlignMobile'
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
                    'content-image--isCenterTopAlignDesktop' => 'Center Top',
                    'content-image--isCenterCenterAlignDesktop' => 'Center Center',
                    'content-image--isCenterBottomAlignDesktop' => 'Center Bottom',
                    'content-image--isLeftTopAlignDesktop' => 'Left Top',
                    'content-image--isLeftCenterAlignDesktop' => 'Left Center',
                    'content-image--isLeftBottomAlignDesktop' => 'Left Bottom',
                    'content-image--isRightTopAlignDesktop' => 'Right Top',
                    'content-image--isRightCenterAlignDesktop' => 'Right Center',
                    'content-image--isRightBottomAlignDesktop' => 'Right Bottom',
                ],
                'default_value' => 'content-image--isCenterCenterAlignDesktop'
            ],
            [
                'label' => 'Full Width Image',
                'name' => 'fullWidthImage',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1
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
                'required' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
                'instructions' => 'The content overlaying the image. Character Recommendations: Title: 30-100, Content: 80-250.'
            ],
        ]
    ]
]);
