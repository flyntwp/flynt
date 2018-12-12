<?php

namespace Flynt\Components\AccordionDefault;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=AccordionDefault', function ($data) {
    Component::enqueueAssets('AccordionDefault');
    return $data;
});
