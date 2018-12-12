<?php

namespace Flynt\Components\GridListSteps;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridListSteps', function ($data) {
    Component::enqueueAssets('GridListSteps');

    return $data;
});
