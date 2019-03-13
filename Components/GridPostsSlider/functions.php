<?php

namespace Flynt\Components\GridPostsSlider;

use Flynt\Api;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=GridPostsSlider', function ($data) {
    $posts = Timber::get_posts([
        'post_type'         => 'post',
        'posts_per_page'    => -1,
        'category'          => $data['category']
    ]);

    $data['posts'] = $posts;

    return $data;
});

Api::registerFields('GridPostsSlider', [
    'layout' => [
        'name' => 'gridPostsSlider',
        'label' => 'Grid: Posts Slider',
        'sub_fields' => [
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
                'label' => 'CTA Button',
                'type' => 'link',
                'instructions' => 'It may be helpfull to add a link to an archive page with all posts.',
                'name' => 'ctaButton',
                'return_format' => 'array'
            ]
        ]
    ]
]);
