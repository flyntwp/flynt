<?php

namespace Flynt\Components\GridContentLists;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=GridContentLists', function ($data) {
    Component::enqueueAssets('GridContentLists');

    return $data;
});
