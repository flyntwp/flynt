<?php

namespace Flynt\Components\SliderImageGallery;

use Flynt\Api;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SliderImageGallery', function ($data) {
    $data['jsonData'] = [
        'options' => Options::get('translatableOptions', 'feature', 'SliderOptions')
    ];
    return $data;
});

Api::registerFields('SliderImageGallery', [
    'layout' => [
        'name' => 'sliderImageGallery',
        'label' => 'Slider: Image Gallery',
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
                    Api::loadFields('FieldVariables', 'theme')
                ]
            ]
        ]
    ]
]);
