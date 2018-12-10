<?php

namespace Flynt\Components\GridListSteps;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridListSteps', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('GridListSteps');
    });

    return $data;
});
