<?php

namespace Flynt\Components\ListSearchResults;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=ListSearchResults', function ($data, $parentData) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('ListSearchResults');
    });

    if (!isset($data['pagination']) && isset($parentData['pagination'])) {
        $data['pagination'] = $parentData['pagination'];
    }
    if (!isset($data['posts']) && isset($parentData['posts'])) {
        $data['posts'] = $parentData['posts'];
    }
    if (!isset($data['postsCount']) && isset($parentData['postsCount'])) {
        $data['postsCount'] = $parentData['postsCount'];
    }
var_dump($data['postsCount']);die();
    return $data;
}, 10, 2);
