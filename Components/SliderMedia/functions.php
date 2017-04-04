<?php
namespace Flynt\Components\SliderMedia;

use Flynt\Features\Components\Component;
use Flynt\Utils\DomNode;

add_filter('Flynt/addComponentData?name=SliderMedia', function ($data) {
    $data['mediaSlides'] = array_map(function ($item) {
        if ($item['mediaType'] == 'oembed') {
            $item['oembedLazyLoad'] = DomNode::setSrcDataAttribute(
                $item['oembed'],
                'iframe',
                'src',
                [
                'autoplay' => 'true'
                ]
            );
        }
        return $item;
    }, $data['mediaSlides']);

    // Show a title/caption for the Media Slider - true | false
    $data['sliderMediaTitle'] = true;

    // Should the Media Slider Title be above or below the slide? - above | below
    $data['sliderMediaTitlePosition'] = 'below';

    $data['sliderMediaUsePoster'] = true;

    return $data;
});

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('SliderMedia', [
    [
      'name' => 'normalize',
      'path' => 'vendor/normalize.css',
      'type' => 'style'
    ],
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
