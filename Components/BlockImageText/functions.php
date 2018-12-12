<?php

namespace Flynt\Components\BlockImageText;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockImageText', function ($data) {
    Component::enqueueAssets('BlockImageText');

    return $data;
});
