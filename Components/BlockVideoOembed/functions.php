<?php

namespace Flynt\Components\BlockVideoOembed;

use Flynt\Features\Components\Component;
use Flynt\Utils\Oembed;

add_filter('Flynt/addComponentData?name=BlockVideoOembed', function ($data) {
    Component::enqueueAssets('BlockVideoOembed');

    $data['video'] = Oembed::setSrcAsDataAttribute(
        $data['oembed'],
        [
            'autoplay' => 'true'
        ]
    );

    return $data;
});
