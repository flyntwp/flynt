<?php

namespace Flynt\Components\ListSearchResults;

use Flynt\Api;
use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListSearchResults', function ($data) {
    $data['prevIcon'] = Asset::getContents('Components/ListSearchResults/Assets/navigation-prev.svg');
    $data['nextIcon'] = Asset::getContents('Components/ListSearchResults/Assets/navigation-next.svg');
    $data['searchIcon'] = Asset::getContents('Components/ListSearchResults/Assets/search.svg');

    return $data;
});

Options::addGlobal('ListSearchResults', [
    Api::loadFields('FieldVariables', 'theme')
]);

Options::addTranslatable('ListSearchResults', [
    [
        'label' => 'Title Content',
        'name' => 'searchTitleHtml',
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
        'label' => 'Search placeholder text',
        'name' => 'searchPlaceholder',
        'type' => 'text',
        'required' => 1,
        'default_value' => 'Search...',
        'instructions' => 'The text for the input field.'
    ],
    [
        'name' => 'previousLabel',
        'label' => 'Previous Label',
        'type' => 'text',
        'default_value' => 'Previous',
        'required' => 1
    ],
    [
        'name' => 'nextLabel',
        'label' => 'Next Label',
        'type' => 'text',
        'default_value' => 'Next',
        'required' => 1
    ],
    [
        'name' => 'search',
        'label' => 'Search',
        'type' => 'text',
        'default_value' => 'Search',
        'required' => 1
    ]
]);
