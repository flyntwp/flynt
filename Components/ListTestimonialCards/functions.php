<?php

namespace Flynt\Components\ListTestimonialCards;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=ListTestimonialCards', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('ListTestimonialCards');
    });

    return $data;
});
