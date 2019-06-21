<?php

namespace Flynt\Components\HeroImageText;

use Flynt\Api;

Api::registerFields('HeroImageCta', [
    'layout' => [
        'name' => 'heroImageCta',
        'label' => 'Hero: Image Cta',
        'sub_fields' => [
            [
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'mime_types' => 'jpg,jpeg',
                'required' => 1,
                'instructions' => 'Recommended resolution greater than 1320 x 640 px.'
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
                'label' => 'Cover Image with Background Color',
                'name' => 'coverImageWithBackgroundColor',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1
            ]
        ]
    ]
]);
