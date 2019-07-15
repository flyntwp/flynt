<?php

namespace Flynt\Components\GridPostsLatest;

use Flynt\Api;
use Flynt\Utils\Options;
use Timber\Timber;

const POST_TYPE = 'post';

add_filter('Flynt/addComponentData?name=GridPostsLatest', function ($data) {
    $postType = POST_TYPE;

    $data['items'] = Timber::get_posts([
        'post_status' => 'publish',
        'post_type' => $postType,
        'category' => $data['taxonomy'],
        'posts_per_page' => $data['options']['postCount'],
        'ignore_sticky_posts' => 1
    ]);

    $data['postTypeArchiveLink'] = get_post_type_archive_link($postType);

    return $data;
});

Api::registerFields('GridPostsLatest', [
    'layout' => [
        'name' => 'GridPostsLatest',
        'label' => 'Grid: Posts Latest',
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
                'name' => 'taxonomy',
                'type' => 'taxonomy',
                'instructions' => 'Select a category or leave empty to show from all posts.',
                'taxonomy' => 'category',
                'field_type' => 'select',
                'allow_null' => 0,
                'multiple' => 0,
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'object'
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
                    Api::loadFields('FieldVariables', 'theme'),
                    [
                        'label' => 'Post Count',
                        'name' => 'postCount',
                        'type' => 'number',
                        'default_value' => 3,
                        'min' => 1,
                        'max' => 4,
                        'step' => 1
                    ]
                ]
            ],
        ]
    ]
]);

Options::addTranslatable('GridPostsLatest', [
    [
        'label' => 'Labels',
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => false
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Reading Time Label',
                'name' => 'readingTime',
                'type' => 'text',
                'default_value' => 'min',
                'required' => 1,
            ],
            [
                'label' => 'All Posts Label',
                'name' => 'allPosts',
                'type' => 'text',
                'default_value' => 'See More Posts',
                'required' => 1,
            ],
            [
                'label' => 'Read More Label',
                'name' => 'readMore',
                'type' => 'text',
                'default_value' => 'Read More',
                'required' => 1,
            ]
        ],
    ]
]);
