<?php

namespace Flynt\Components\GridContentLists;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridContentList', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('GridContentList');
    });

    return $data;
});
