<?php

namespace Flynt\Components\GridPosts;

use Flynt\Api;
use Flynt\Utils\Options;
use Timber\Term;

const POST_TYPE = 'post';
const FILTER_BY_TAXONOMY = 'category';

add_filter('Flynt/addComponentData?name=GridPosts', function ($data) {
    if ($data['showFilters']) {
        $postType = $data['postType'] ?? POST_TYPE;
        $taxonomy = $data['filterByTaxonomy'] ?? FILTER_BY_TAXONOMY;
        if ($data['visibleFilters']) {
            $terms = $data['visibleFilters'];
        } else {
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'hide_empty' => true,
            ]);
        }
        $queriedObject = get_queried_object();
        $data['terms'] = array_map(function ($term) use ($queriedObject) {
            $timberTerm = new Term($term);
            $timberTerm->isActive = $queriedObject->taxonomy === $term->taxonomy && $queriedObject->term_id === $term->term_id;
            return $timberTerm;
        }, $terms);
        // Add item form all posts
        array_unshift($data['terms'], [
            'link' => get_post_type_archive_link($postType),
            'title' => $data['labels']['allPosts'],
            'isActive' => is_home() || is_post_type_archive($postType),
        ]);
    }

    return $data;
});

function loadFields($taxonomy = FILTER_BY_TAXONOMY)
{
    $fields = [];
    if (!empty($taxonomy)) {
        $fields = [
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
                'taxonomy' => $taxonomy,
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
        ];
    }
    $fields = array_merge($fields, [
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
            'label' => 'Load More Button?',
            'name' => 'loadMore',
            'type' => 'true_false',
            'default_value' => 0,
            'ui' => true
        ],
    ]);
    return $fields;
};

Options::addTranslatable('GridPosts', [
    [
        'label' => 'Labels',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Previous Label',
                'name' => 'previous',
                'type' => 'text',
                'default_value' => 'Previous',
                'required' => 1,
            ],
            [
                'label' => 'Next Label',
                'name' => 'next',
                'type' => 'text',
                'default_value' => 'Next',
                'required' => 1,
            ],
            [
                'label' => 'Load More Label',
                'name' => 'loadMore',
                'type' => 'text',
                'default_value' => 'Load more',
                'required' => 1,
            ],
            [
                'label' => 'No Posts Found Text',
                'name' => 'noPostsFound',
                'type' => 'text',
                'default_value' => 'No posts found.',
                'required' => 1,
            ],
            [
                'label' => 'All Posts Label',
                'name' => 'allPosts',
                'type' => 'text',
                'default_value' => 'All',
                'required' => 1,
            ],
        ],
    ],
]);
