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
                'label' => 'Title',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'media_upload' => 0,
                'toolbar' => 'full',
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Images',
                'name' => 'images',
                'type' => 'gallery',
                'min' => 1,
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg',
                'required' => 1
            ]
        ]
    ]
]);
