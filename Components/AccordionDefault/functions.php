<?php

namespace Flynt\Components\AccordionDefault;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=AccordionDefault', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('AccordionDefault');
    });
    return $data;
});
