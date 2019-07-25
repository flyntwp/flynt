<?php

namespace Flynt\Components\ListSearchResults;

use Flynt\Api;
use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Timber\Timber;

Options::addTranslatable('ListSearchResults', [
    [
        'label' => 'Title',
        'name' => 'preContentHtml',
        'type' => 'wysiwyg',
        'required' => 1,
        'default_value' => 'Search Result ',
        'instructions' => 'Title of the search Page.',
        'media_upload' => 0,
        'delay' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
    ],
    [
        'label' => 'Placeholder - Search',
        'name' => 'searchPlaceholder',
        'type' => 'text',
        'required' => 1,
        'default_value' => 'Search...',
        'instructions' => 'The text for the input field.'
    ],
    [
        'label' => 'Label - Previous',
        'name' => 'previousLabel',
        'type' => 'text',
        'default_value' => 'Previous',
        'required' => 1
    ],
    [
        'label' => 'Label - Next',
        'name' => 'nextLabel',
        'type' => 'text',
        'default_value' => 'Next',
        'required' => 1
    ],
    [
        'label' => 'Label - Search',
        'name' => 'search',
        'type' => 'text',
        'default_value' => 'Search',
        'required' => 1
    ],
    [
        'label' => 'Label - Read More',
        'name' => 'readMore',
        'type' => 'text',
        'default_value' => 'Read More',
        'required' => 1
    ]
]);
