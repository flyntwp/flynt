<?php

namespace Flynt\Components\ListTestimorialsCards;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=ListTestimorialsCards', function ($data) {
    Component::enqueueAssets('ListTestimorialsCards');

    return $data;
});
