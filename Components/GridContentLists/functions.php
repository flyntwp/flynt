<?php

namespace Flynt\Components\GridContentLists;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=GridContentLists', function ($data) {
    Component::enqueueAssets('GridContentLists');

    return $data;
});
