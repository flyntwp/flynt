<?php

namespace Flynt\Components\GridPosts;

use Flynt\Api;
use Flynt\Utils\Options;
use Timber\Term;

const POST_TYPE = 'post';
const FILTER_BY_TAXONOMY = 'category';

add_filter('Flynt/addComponentData?name=GridPosts', function ($data) {
    if ($data['showFilters']) {
        if ($data['visibleFilters']) {
            $terms = $data['visibleterms'];
        } else {
            $terms = get_terms([
                'taxonomy' => FILTER_BY_TAXONOMY,
                'hide_empty' => true,
            ]);
        }
        $data['terms'] = array_map(function ($term) {
            return new Term($term);
        }, $terms);


        $data['archiveUrl'] = get_post_type_archive_link(POST_TYPE);
    }

    return $data;
});

Api::registerFields('GridPosts', [
    'layout' => [
        'name' => 'gridPosts',
        'label' => 'Grid: Posts',
        'sub_fields' => [
            [
                'label' => 'Show Filters?',
                'name' => 'showFilters',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => true
            ],
            [
                'label' => 'Visible Filters',
                'name' => 'visibleFilters',
                'type' => 'taxonomy',
                'taxonomy' => FILTER_BY_TAXONOMY,
                'field_type' => 'multi_select',
                'allow_null' => true,
                'multiple' => true,
                'add_term' => false,
                'return_format' => 'object',
                'instructions' => 'Select none to show filters for all available terms.',
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'showFilters',
                            'operator' => '==',
                            'value' => 1,
                        ],
                    ],
                ],
            ],
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
            ]
        ]
    ]
]);

Options::addTranslatable('GridPosts', [
    [
        'label' => 'Labels',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'name' => 'previous',
                'label' => 'Previous Label',
                'type' => 'text',
                'default_value' => 'Previous',
                'required' => 1,
            ],
            [
                'name' => 'next',
                'label' => 'Next Label',
                'type' => 'text',
                'default_value' => 'Next',
                'required' => 1,
            ],
            [
                'name' => 'noPostsFound',
                'label' => 'No Posts Found Text',
                'type' => 'text',
                'default_value' => 'No posts found.',
                'required' => 1,
            ],
            [
                'name' => 'allPosts',
                'label' => 'All Posts Label',
                'type' => 'text',
                'default_value' => 'All',
                'required' => 0,
            ],
        ],
    ],
]);
