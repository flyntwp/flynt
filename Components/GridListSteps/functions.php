<?php

namespace Flynt\Components\GridListSteps;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=GridListSteps', function ($data) {
    Component::enqueueAssets('GridListSteps');

    return $data;
});
