<?php
namespace Flynt\Components\ListPostCards;

use Flynt\Api;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListPostCards', function ($data) {
    $posts = Timber::get_posts([
        'post_type'         => 'post',
        'posts_per_page'    => 4,
        'category'          => $data['category']
    ]);

    $data['posts'] = $posts;

    return $data;
});

Api::registerFields('ListPostCards', [
    'layout' => [
        'name' => 'listPostCards',
        'label' => 'List: Post Cards',
        'sub_fields' => [
            [
                'label' => 'Pre-Content',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'instructions' => 'Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.',
                'tabs' => 'visual,text',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
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
