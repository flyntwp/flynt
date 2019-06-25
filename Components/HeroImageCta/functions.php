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
                'label' => 'Align Image',
                'name' => 'alignImage',
                'type' => 'group',
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'label' => 'Desktop',
                        'name' => 'desktop',
                        'type' => 'group',
                        'sub_fields' => [
                            [
                                'label' => ' Horizontal',
                                'name' => 'horizontal',
                                'type' => 'select',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 1,
                                'ajax' => 0,
                                'choices' => [
                                    'desktopHorizontalAlign--left' => 'Left',
                                    'desktopHorizontalAlign--center' => 'Center',
                                    'desktopHorizontalAlign--right' => 'Right',
                                ],
                                'default_value' => 'desktopHorizontalAlign--center'
                            ],
                            [
                                'label' => 'Vertical',
                                'name' => 'vertical',
                                'type' => 'select',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 1,
                                'ajax' => 0,
                                'choices' => [
                                    'desktopVerticalAlign--top' => 'Top',
                                    'desktopVerticalAlign--center' => 'Center',
                                    'desktopVerticalAlign--bottom' => 'Bottom',
                                ],
                                'default_value' => 'desktopVerticalAlign--center'
                            ],
                        ]
                    ],
                    [
                        'label' => 'Mobile',
                        'name' => 'mobile',
                        'type' => 'group',
                        'sub_fields' => [
                            [
                                'label' => ' Horizontal',
                                'name' => 'horizontal',
                                'type' => 'select',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 1,
                                'ajax' => 0,
                                'choices' => [
                                    'mobileHorizontalAlign--left' => 'Left',
                                    'mobileHorizontalAlign--center' => 'Center',
                                    'mobileHorizontalAlign--right' => 'Right',
                                ],
                                'default_value' => 'mobileHorizontalAlign--center'
                            ],
                            [
                                'label' => 'Vertical',
                                'name' => 'vertical',
                                'type' => 'select',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 1,
                                'ajax' => 0,
                                'choices' => [
                                    'mobileVerticalAlign--top' => 'Top',
                                    'mobileVerticalAlign--center' => 'Center',
                                    'mobileVerticalAlign--bottom' => 'Bottom',
                                ],
                                'default_value' => 'mobileVerticalAlign--center'
                            ],
                        ]
                    ],
                ]
            ],
            [
                'label' => 'Restrict image width to container',
                'name' => 'hasContainerWidth',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1
            ],
            [
                'label' => 'Theme',
                'name' => 'theme',
                'type' => 'select',
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'ajax' => 0,
                'choices' => [
                    'themeNoBackground' => 'No Background',
                    'themeDefault' => 'Default',
                    'themeLight' => 'Light',
                    'themeDark' => 'Dark',
                    'themeHero' => 'Hero'
                ],
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
