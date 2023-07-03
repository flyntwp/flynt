<?php

namespace Flynt\Components\BlockVideoOembed;

use Flynt\FieldVariables;
use Flynt\Utils\Oembed;

add_filter('Flynt/addComponentData?name=BlockVideoOembed', function ($data) {
    $data['oembed'] = Oembed::setSrcAsDataAttribute(
        $data['oembed'],
        [
            'autoplay' => 'true'
        ]
    );

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockVideoOembed',
        'label' =>  __('Block: Video Oembed', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Poster Image', 'flynt'),
                'instructions' => __('Recommended Size: Min-Width 1920px; Min-Height: 1080px; Image-Format: JPG, PNG. Aspect Ratio 16/9.', 'flynt'),
                'name' => 'posterImage',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg',
                'required' => 1
            ],
            [
                'label' => __('Video', 'flynt'),
                'name' => 'oembed',
                'type' => 'oembed',
                'required' => 1,
                'videoParams' => [
                    'autoplay' => 1,
                ]
            ],
            [
                'label' => __('Options', 'flynt'),
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
                    FieldVariables\getTheme(),
                    [
                        'label' => __('Size', 'flynt'),
                        'name' => 'size',
                        'type' => 'radio',
                        'other_choice' => 0,
                        'save_other_choice' => 0,
                        'layout' => 'horizontal',
                        'choices' => [
                            'small' => __('Small', 'flynt'),
                            'medium' => __('Medium (Default)', 'flynt'),
                            'large' => __('Large', 'flynt'),
                            'full' => __('Full', 'flynt'),
                        ],
                        'default_value' => 'medium',
                    ],
                ]
            ]
        ]
    ];
}
