<?php

namespace Flynt\Components\GridContentLists;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridContentLists', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('GridContentLists');
    });

    return $data;
});
