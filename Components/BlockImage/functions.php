<?php

namespace Flynt\Components\BlockImage;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=BlockImage', function ($data) {
    Component::enqueueAssets('BlockImage');

    return $data;
});
