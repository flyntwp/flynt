<?php

namespace Flynt\Components\GridPosts;

use Flynt\Features\Components\Component;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=GridPosts', function ($data, $parentData) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('GridPosts');
    });

    $data['pagination'] = (isset($parentData['pagination'])) ? $parentData['pagination'] : null;
    if (!isset($data['posts']) && isset($parentData['posts'])) {
        $data['posts'] = $parentData['posts'];
    }

    return $data;
}, 10, 2);
