<?php

namespace Flynt\Components\ListSearchResults;

use Flynt\Utils\Options;

Options::addTranslatable('ListSearchResults', [
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
        'required' => 1,
        'default_value' => 'Search Result ',
        'instructions' => 'Pre-Content of the search Page.',
        'media_upload' => 0,
        'delay' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
    ],
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
                'label' => 'Previous',
                'name' => 'previousLabel',
                'type' => 'text',
                'default_value' => 'Previous',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Next',
                'name' => 'nextLabel',
                'type' => 'text',
                'default_value' => 'Next',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Placeholder - Search',
                'name' => 'searchPlaceholder',
                'type' => 'text',
                'required' => 1,
                'default_value' => 'Search...',
                'instructions' => 'The text for the input field.',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Button - Search',
                'name' => 'search',
                'type' => 'text',
                'default_value' => 'Search',
                'required' => 1,
                'instructions' => 'The text for the search button.',
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Read More',
                'name' => 'readMore',
                'type' => 'text',
                'default_value' => 'Read More',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'No Results',
                'name' => 'noResults',
                'type' => 'text',
                'default_value' => 'No results found.',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
