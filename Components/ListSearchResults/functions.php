<?php

namespace Flynt\Components\ListSearchResults;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Flynt\Utils\Component;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListSearchResults', function ($data) {
    global $wp_query;
    $searchQuery = get_search_query();
    $data['searchTerm'] = $searchQuery;

    if (!empty($searchQuery)) {
        $data['searchTerm'] = $searchQuery;
    }

    $data['pagination'] = Timber::get_pagination();
    $data['prevIcon'] = Asset::getContents('Components/ListSearchResults/Assets/navigation-prev.svg');
    $data['nextIcon'] = Asset::getContents('Components/ListSearchResults/Assets/navigation-next.svg');
    $data['searchIcon'] = Asset::getContents('Components/ListSearchResults/Assets/search.svg');

    return $data;
});

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
]);
