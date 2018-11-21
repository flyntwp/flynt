<?php

namespace Flynt\Components\BlockNotFound;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockNotFound', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('BlockNotFound');
    });

    return $data;
});
