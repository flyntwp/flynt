<?php

namespace Flynt\Components\BlockMediaText;

use Flynt\Utils\Component;
use Flynt\Utils\Oembed;

add_filter('Flynt/addComponentData?name=BlockMediaText', function ($data) {
    Component::enqueueAssets('BlockMediaText');
    if ($data['mediaType'] === 'oembedVideo') {
        $data['oembedLazyLoad'] = Oembed::setSrcAsDataAttribute(
            $data['oembed'],
            [
                'autoplay' => 'true'
            ]
        );
    }
    return $data;
});
