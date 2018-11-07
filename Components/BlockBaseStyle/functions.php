<?php

namespace Flynt\Components\BlockBaseStyle;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockBaseStyle', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('BlockBaseStyle');
    });
    return $data;
});
