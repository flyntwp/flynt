<?php
namespace Flynt\Components\SliderMedia;

use Flynt\Features\Components\Component;
use Flynt\Utils\Oembed;

add_filter('Flynt/addComponentData?name=SliderMedia', function ($data) {
    $data['mediaSlides'] = array_map(function ($item) {
        if ($item['mediaType'] == 'oembed') {
            $item['oembedLazyLoad'] = Oembed::setOembedSrcAsDataAttribute(
                $item['oembed'],
                [
                    'autoplay' => 'true'
                ]
            );
        }
        return $item;
    }, $data['mediaSlides']);

    return $data;
});

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('SliderMedia', [
        [
            'name' => 'slick-carousel',
            'path' => 'vendor/slick.js',
            'type' => 'script'
        ],
        [
            'name' => 'slick-carousel',
            'path' => 'vendor/slick.css',
            'type' => 'style'
        ]
    ]);
});
