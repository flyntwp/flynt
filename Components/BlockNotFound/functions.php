<?php

namespace Flynt\Components\BlockNotFound;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=BlockNotFound', function ($data) {
    Component::enqueueAssets('BlockNotFound');

    return $data;
});
