<?php

namespace Flynt\Components\SliderImages;

use Flynt\Api;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SliderImages', function ($data) {
    $translatableOptions = Options::get('translatableOptions', 'feature', 'SliderOptions');
    $data['jsonData'] = [
        'options' => array_merge($translatableOptions, $data['options']),
    ];
    return $data;
});

Api::registerFields('SliderImages', [
    'layout' => [
        'name' => 'sliderImages',
        'label' => 'Slider: Images',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => 'Title',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'media_upload' => 0,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Images',
                'name' => 'images',
                'type' => 'gallery',
                'min' => 2,
                'preview_size' => 'medium',
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
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => 'Enable Autoplay',
                        'name' => 'autoplay',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1
                    ],
                    [
                        'label' => 'Autoplay Speed (in milliseconds)',
                        'name' => 'autoplaySpeed',
                        'type' => 'number',
                        'min' => 2000,
                        'step' => 1,
                        'default_value' => 4000,
                        'required' => 1,
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'autoplay',
                                    'operator' => '==',
                                    'value' => 1
                                ]
                            ]
                        ],
                    ],
                    Api::loadFields('FieldVariables', 'theme')
                ]
            ]
        ]
    ]
]);
