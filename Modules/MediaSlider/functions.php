<?php
namespace WPStarterTheme\Modules\MediaSlider;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=MediaSlider', function ($data) {
  $data['mediaSlides'] = [
    [
      'mediaType' => 'image',
      'image' => [
        'url' => 'http://placehold.it/1500x500'
      ],
      'titleText' => '1 Hello World'
    ],
    [
      'mediaType' => 'image',
      'image' => [
        'url' => 'http://placehold.it/1500x500'
      ],
      'titleText' => '2 Hello World this is a bit longer'
    ],
    [
      'mediaType' => 'image',
      'image' => [
        'url' => 'http://placehold.it/1500x500'
      ],
      'titleText' => '3 Lorem ipsum dolor sit amet'
    ],
    [
      'mediaType' => 'image',
      'image' => [
        'url' => 'http://placehold.it/1500x500'
      ],
      'titleText' => '4 Hello World'
    ]
  ];

  return $data;
});

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('MediaSlider', [
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
