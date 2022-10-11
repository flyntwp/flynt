<?php

namespace Flynt\Components\BlockPostFooter;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=BlockPostFooter', function ($data) {

    return $data;
});

Options::addTranslatable('BlockPostFooter', [
    [
        'label' => __('Labels', 'flynt'),
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
                'label' => __('Tags', 'flynt'),
                'name' => 'tagsLabel',
                'type' => 'text',
                'default_value' => __('Tags', 'flynt'),
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Posted by', 'flynt'),
                'name' => 'postedByLabel',
                'type' => 'text',
                'default_value' => __('Posted by', 'flynt'),
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
