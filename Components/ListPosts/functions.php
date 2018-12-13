<?php

namespace Flynt\Components\ListPosts;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=ListPosts', function ($data, $parentData) {
    Component::enqueueAssets('ListPosts');
    $data['isArchive'] = is_home() || is_archive();

    $data['pagination'] = (isset($parentData['pagination'])) ? $parentData['pagination'] : null;
    if (!isset($data['posts']) && isset($parentData['posts'])) {
        $data['posts'] = $parentData['posts'];
    }

    return $data;
}, 10, 2);
