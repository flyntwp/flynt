<?php

namespace Flynt\Components\BlockWysiwyg;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockWysiwyg', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('BlockWysiwyg');
    });

    return $data;
});
