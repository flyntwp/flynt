<?php

namespace Flynt\Components\ListSearchResults;

use Flynt\Utils\Options;

Options::addTranslatable('ListSearchResults', [
    [
        'label' => __('General', 'flynt'),
        'name' => 'generalTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Title', 'flynt'),
        'name' => 'preContentHtml',
        'type' => 'wysiwyg',
        'required' => 1,
        'default_value' => 'Search Result ',
        'instructions' => __('Title of the search Page.', 'flynt'),
        'media_upload' => 0,
        'delay' => 1,
    ],
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
                'label' => __('Previous', 'flynt'),
                'name' => 'previousLabel',
                'type' => 'text',
                'default_value' => 'Previous',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Next', 'flynt'),
                'name' => 'nextLabel',
                'type' => 'text',
                'default_value' => 'Next',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Placeholder - Search', 'flynt'),
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
                'label' => __('Button - Search', 'flynt'),
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
                'label' => __('Read More', 'flynt'),
                'name' => 'readMore',
                'type' => 'text',
                'default_value' => 'Read More',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('No Results', 'flynt'),
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
