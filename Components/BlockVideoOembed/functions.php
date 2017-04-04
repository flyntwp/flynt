<?php
namespace Flynt\Components\BlockVideoOembed;

use Flynt\Features\Components\Component;
use Flynt\Utils\DomNode;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('BlockVideoOembed');
});

add_filter('Flynt/addComponentData?name=BlockVideoOembed', function ($data) {
    $data['oembedLazyLoad'] = DomNode::setSrcDataAttribute(
        $data['oembed'],
        'iframe',
        'src',
        [
            'autoplay' => 'true'
        ]
    );

    return $data;
});
