<?php

namespace Flynt\Components\HeroCta;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=HeroCta', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('HeroCta');
    });

    return $data;
});
