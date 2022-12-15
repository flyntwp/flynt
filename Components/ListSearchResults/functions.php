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
        'instructions' => __('Title of the search Page.', 'flynt'),
        'name' => 'preContentHtml',
        'type' => 'wysiwyg',
        'required' => 1,
        'default_value' => __('Search Result', 'flynt'),
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
                'name' => 'previous',
                'type' => 'text',
                'default_value' => __('Prev', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Next', 'flynt'),
                'name' => 'next',
                'type' => 'text',
                'default_value' => __('Next', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Placeholder - Search', 'flynt'),
                'instructions' => __('The text for the input field.', 'flynt'),
                'name' => 'searchPlaceholder',
                'type' => 'text',
                'required' => 1,
                'default_value' => __('Search …', 'flynt'),
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Button - Search', 'flynt'),
                'instructions' => __('The text for the search button', 'flynt'),
                'name' => 'search',
                'type' => 'text',
                'default_value' => __('Search', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Read More', 'flynt'),
                'name' => 'readMore',
                'type' => 'text',
                'default_value' => __('Read More', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('No Results', 'flynt'),
                'name' => 'noResults',
                'type' => 'text',
                'default_value' => __('No results found.', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
