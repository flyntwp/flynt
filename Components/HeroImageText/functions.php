<?php

namespace Flynt\Components\HeroImageText;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=HeroImageText', function ($data) {
    Component::enqueueAssets('HeroImageText');

    return $data;
});
