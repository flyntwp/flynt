<?php

namespace Flynt\Components\BlockImage;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockImage', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('BlockImage');
    });

    return $data;
});
