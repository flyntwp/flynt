<?php

namespace Flynt\Components\HeroImage;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=HeroImage', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('HeroImage');
    });

    return $data;
});
