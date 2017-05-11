<?php
namespace Flynt\Components\BlockVideoOembed;

use Flynt\Features\Components\Component;
use Flynt\Utils\Oembed;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('BlockVideoOembed');
});

add_filter('Flynt/addComponentData?name=BlockVideoOembed', function ($data) {
    $data['oembedLazyLoad'] = Oembed::setOembedSrcAsDataAttribute(
        $data['oembed'],
        [
            'autoplay' => 'true'
        ]
    );

    return $data;
});
