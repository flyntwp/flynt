<?php

namespace Flynt\Components\ListTestimonialCards;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=ListTestimonialCards', function ($data) {
    Component::enqueueAssets('ListTestimonialCards');

    return $data;
});
