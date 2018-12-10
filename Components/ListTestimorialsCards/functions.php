<?php

namespace Flynt\Components\ListTestimorialsCards;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=ListTestimorialsCards', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('ListTestimorialsCards');
    });

    return $data;
});
