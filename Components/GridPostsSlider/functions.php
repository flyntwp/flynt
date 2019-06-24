<?php

namespace Flynt\Components\GridPostsSlider;

use Flynt\Api;
use Timber\Timber;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=GridPostsSlider', function ($data) {
    $posts = Timber::get_posts([
        'post_type'         => 'post',
        'posts_per_page'    => -1,
        'category'          => $data['category']
    ]);

    $data['posts'] = $posts;

    $translatableOptions = Options::get('translatableOptions', 'feature', 'SliderOptions');
    $data['jsonData'] = [
        'options' => array_merge($translatableOptions, $data['options']),
    ];

    return $data;
});

Api::registerFields('GridPostsSlider', [
    'layout' => [
        'name' => 'gridPostsSlider',
        'label' => 'Grid: Posts Slider',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                "label" => "Content HTML",
                "name" => "contentHtml",
                "type" => "wysiwyg",
                "tabs" => "visual,text",
                "toolbar" => "full",
                "media_upload" => false,
                "delay" => true
            ],
            [
                'label' => 'Category',
                'name' => 'category',
                'type' => 'taxonomy',
                'instructions' => 'Narrow down the posts shown by selecting categories, or leave empty to show any latest posts.',
                'taxonomy' => 'category',
                'field_type' => 'multi_select',
                'allow_null' => 0,
                'multiple' => 0,
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'id'
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
                        'default_value' => 4000,
                        'required' => 1,
                        'step' => 1,
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
                ],
            ],
        ]
    ]
]);
