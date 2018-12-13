<?php

Flynt\registerFields('SliderMedia', [
    'layout' => [
        'name' => 'sliderMedia',
        'label' => 'Slider: Media',
        'sub_fields' => [
            [
                'label' => 'Media Slides',
                'name' => 'mediaSlides',
                'type' => 'repeater',
                'layout' => 'row',
                'button_label' => 'Add Slide',
                'min' => 1,
                'sub_fields' => [
                    [
                        'label' => 'Media Type',
                        'name' => 'mediaType',
                        'type' => 'select',
                        'choices' => [
                            'image' => 'Image',
                            'oembed' => 'Video'
                        ],
                        'default_value' => 'image',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'required' => 1,
                        'ui' => 1,
                        'ajax' => 0
                    ],
                    [
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => 1440,
                        'min_height' => 720,
                        'instructions' => 'Recommended Size: Min-Width 1440px; Min-Height: 720px; Image-Format: JPG',
                        'mime_types' => 'jpg,jpeg',
                        'required' => 1,
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'mediaType',
                                    'operator' => '==',
                                    'value' => 'image'
                                ]
                            ]
                        ]
                    ],
                    [
                        'label' => 'Oembed',
                        'name' => 'oembed',
                        'type' => 'oembed',
                        'width' => 100,
                        'height' => 100,
                        'required' => 1,
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'mediaType',
                                    'operator' => '==',
                                    'value' => 'oembed'
                                ]
                            ]
                        ]
                    ],
                    [
                        'name' => 'posterImage',
                        'label' => 'Poster Image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => 1440,
                        'min_height' => 720,
                        'instructions' => 'Recommended Size: Min-Width 1440px; Min-Height: 720px; Image-Format: JPG',
                        'mime_types' => 'jpg,jpeg',
                        'required' => 1,
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'mediaType',
                                    'operator' => '==',
                                    'value' => 'oembed'
                                ]
                            ]
                        ]
                    ],
                    [
                        'name' => 'titleText',
                        'label' => 'Title Text',
                        'type' => 'text'
                    ]
                ]
            ]
        ]
    ]
]);
