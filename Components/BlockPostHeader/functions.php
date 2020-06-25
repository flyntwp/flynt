<?php

namespace Flynt\Components\BlockPostHeader;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=BlockPostHeader', function ($data) {

    return $data;
});

Options::addTranslatable('BlockPostHeader', [
    [
        'label' => 'Labels',
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Posted by',
                'name' => 'postedByLabel',
                'type' => 'text',
                'default_value' => 'Posted by',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => '(Posted) in',
                'name' => 'postedInLabel',
                'type' => 'text',
                'default_value' => 'in',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Reading Time - (20) min read',
                'name' => 'readingtimeLabel',
                'type' => 'text',
                'default_value' => 'min read',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
    [
        'label' => 'Dividers',
        'name' => 'dividersTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => '',
        'name' => 'dividers',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Datetime | Author',
                'name' => 'authorDivider',
                'type' => 'text',
                'default_value' => '-',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Author | Reading Time',
                'name' => 'readingtimeDivider',
                'type' => 'text',
                'default_value' => '|',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
