<?php

namespace Flynt\Components\HeroImage;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=HeroImage', function ($data) {
    Component::enqueueAssets('HeroImage', [
        [
            'name' => 'lazysizes',
            'type' => 'script',
            'path' => 'vendor/lazysizes.js'
        ],
        [
            'name' => 'lazysizes-respimg',
            'type' => 'script',
            'path' => 'vendor/lazysizes-respimg.js'
        ],
        [
            'name' => 'lazysizes-object-fit',
            'type' => 'script',
            'path' => 'vendor/lazysizes-object-fit.js'
        ],
        [
            'name' => 'lazysizes-parent-fit',
            'type' => 'script',
            'path' => 'vendor/lazysizes-parent-fit.js'
        ],
    ]);

    return $data;
});
