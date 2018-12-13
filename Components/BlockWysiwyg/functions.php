<?php

namespace Flynt\Components\BlockWysiwyg;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=BlockWysiwyg', function ($data) {
    Component::enqueueAssets('BlockWysiwyg');

    return $data;
});
