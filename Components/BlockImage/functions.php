<?php

namespace Flynt\Components\BlockImage;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockImage', function ($data) {
    Component::enqueueAssets('BlockImage');

    return $data;
});
