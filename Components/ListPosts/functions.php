<?php

namespace Flynt\Components\ListPosts;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=ListPosts', function ($data) {

    add_filter('timber/post/preview/read_more_class', function ($read_more) {
        return $read_more = "button button--link";
    });

    return $data;
});

Options::addTranslatable('ListPosts', [
    [
        'label' => 'General',
        'name' => 'generalTranslatable',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Label - Posted by',
                'name' => 'postedByLabel',
                'type' => 'text',
                'default_value' => 'Posted by',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Label - (Posted) in',
                'name' => 'postedInLabel',
                'type' => 'text',
                'default_value' => 'in',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Label - Reading Time - (20) min read',
                'name' => 'readingtimeLabel',
                'type' => 'text',
                'default_value' => 'min',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Label - Read More',
                'name' => 'readMoreLabel',
                'type' => 'text',
                'default_value' => 'Read More',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Divider - Datetime | Author',
                'name' => 'authorDivider',
                'type' => 'text',
                'default_value' => '-',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Divider - Author | Reading Time',
                'name' => 'readingtimeDivider',
                'type' => 'text',
                'default_value' => '|',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Label - Previous',
                'name' => 'previousLabel',
                'type' => 'text',
                'default_value' => 'Previous',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Label - Next',
                'name' => 'nextLabel',
                'type' => 'text',
                'default_value' => 'Next',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Notice - No Posts',
                'name' => 'noPostNotice',
                'type' => 'textarea',
                'default_value' => 'No posts found.',
                'maxlength' => 0,
                'rows' => 3,
                'new_lines' => 'wpautop',
                'wrapper' => [
                    'width' => '100',
                ],
            ],
        ],
    ],
]);
