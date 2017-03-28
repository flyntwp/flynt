<?php
namespace Flynt\Components\MediaTextBlock;

use Flynt\Features\Components\Component;
use Flynt\Utils\DomNode;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('MediaTextBlock');
});

add_filter('Flynt/addComponentData?name=MediaTextBlock', function ($data) {
    if ($data['mediaType'] === 'mediaVideo') {
        $data['oembedLazyLoad'] = DomNode::setSrcDataAttribute(
            $data['oembed'],
            'iframe',
            'src',
            [
            'autoplay' => 'true'
            ]
        );
    }

    return $data;
});
