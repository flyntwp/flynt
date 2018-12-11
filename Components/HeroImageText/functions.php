<?php

namespace Flynt\Components\HeroImageText;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=HeroImageText', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('HeroImageText');
    });

    return $data;
});
