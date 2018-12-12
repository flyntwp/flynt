<?php

namespace Flynt\Components\SliderMedia;

use Flynt\Features\Components\Component;
use Flynt\Utils\Oembed;

add_filter('Flynt/addComponentData?name=SliderMedia', function ($data) {
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

    $data['mediaSlides'] = array_map(function ($item) {
        if ($item['mediaType'] == 'oembed') {
            $item['image'] = $item['posterImage'];
            $item['oembedLazyLoad'] = Oembed::setSrcAsDataAttribute(
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
