<?php

namespace Flynt\Components\ListSearchResults;

use Flynt\Utils\Asset;
use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=ListSearchResults', function ($data) {
    Component::enqueueAssets('ListSearchResults');

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
