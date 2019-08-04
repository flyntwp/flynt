<?php

namespace Flynt\Components\ListPosts;

use Flynt\Utils\Options;

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
        ],
    ],
]);
