<?php

namespace Flynt\Components\GridLinkList;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridLinkList', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('GridLinkList');
    });

    return $data;
});
