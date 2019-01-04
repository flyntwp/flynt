<?php

namespace Flynt\Components\ListSearchResults;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=ListSearchResults', function ($data) {
    global $wp_query;
    $data['posts_found'] = $wp_query->found_posts;
    $searchQuery = get_search_query();
    $data['searchTerm'] = $searchQuery;

    if (!empty($data['posts'])) {
        $data['searchResult'] = str_replace('%%resultCount%%', $data['posts_found'], $data['searchResult']);
        $data['searchResult'] = str_replace('%%resultTerm%%', $data['searchTerm'], $data['searchResult']);
    } else {
        $data['searchResult'] = str_replace('%%resultTerm%%', $data['searchTerm'], $data['noResults']);
    }

    if (!empty($searchQuery)) {
        $data['searchTerm'] = $searchQuery;
    }

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
        'label' => 'Search placholder text',
        'name' => 'searchPlaceholder',
        'type' => 'text',
        'required' => 1,
        'default_value' => 'Search...',
        'instructions' => 'The text for the input field.'
    ],
    [
        'label' => 'Successful search text',
        'name' => 'searchResult',
        'type' => 'wysiwyg',
        'required' => 1,
        'media_upload' => 0,
        'delay' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
        'default_value' => 'Es wurden %%resultCount%% Blogeinträge gefunden.',
        'instructions' => 'Sentence for a successful search. The placeholder %%resultCount%% replace the counted results and %%resultTerm%% replace the searching phrase'
    ],
    [
        'label' => 'Unsuccessful text',
        'name' => 'noResults',
        'type' => 'wysiwyg',
        'required' => 1,
        'media_upload' => 0,
        'delay' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
        'default_value' => 'No results found.',
        'instructions' => 'Sentence for an unsuccessful search. The placeholder %%resultCount%% replace the counted results and %%resultTerm%% replace the searching phrase'
    ]
]);
