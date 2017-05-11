<?php
namespace Flynt\Components\BlockMediaText;

use Flynt\Features\Components\Component;
use Flynt\Utils\Oembed;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('BlockMediaText');
});

add_filter('Flynt/addComponentData?name=BlockMediaText', function ($data) {
    if ($data['mediaType'] === 'oembedVideo') {
        $data['oembedLazyLoad'] = Oembed::setOembedSrcAsDataAttribute(
            $data['oembed'],
            [
                'autoplay' => 'true'
            ]
        );
    }
    return $data;
});
