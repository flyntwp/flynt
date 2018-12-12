<?php

namespace Flynt\Components\GridPosts;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridPosts', function ($data, $parentData) {
    Component::enqueueAssets('GridPosts');

    $data['pagination'] = (isset($parentData['pagination'])) ? $parentData['pagination'] : null;
    if (!isset($data['posts']) && isset($parentData['posts'])) {
        $data['posts'] = $parentData['posts'];
    }

    return $data;
}, 10, 2);
