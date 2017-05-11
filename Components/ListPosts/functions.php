<?php

namespace Flynt\Components\ListPosts;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('ListPosts');
});

add_filter('Flynt/addComponentData?name=ListPosts', function ($data, $parentData) {
    $data['isArchive'] = is_home() || is_archive();

    $data['pagination'] = (isset($parentData['pagination'])) ? $parentData['pagination'] : null;
    if (!isset($data['posts']) && isset($parentData['posts'])) {
        $data['posts'] = $parentData['posts'];
    }

    return $data;
}, 10, 2);
