<?php

namespace Flynt\Components\HeroCta;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=HeroCta', function ($data) {
    Component::enqueueAssets('HeroCta');

    return $data;
});
