<?php

namespace Flynt\Components\BlockBaseStyle;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=BlockBaseStyle', function ($data) {
    Component::enqueueAssets('BlockBaseStyle');
    return $data;
});
