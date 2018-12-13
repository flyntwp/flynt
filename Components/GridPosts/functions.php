<?php

namespace Flynt\Components\GridPosts;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=GridPosts', function ($data) {
    Component::enqueueAssets('GridPosts');

    return $data;
}, 10, 2);
