<?php
namespace WPStarterTheme\Modules\MediaSlider;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Log;
use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=MediaSlider', function ($data) {
  $imageConfig = [
    'default' => 'large',
    'sizes' => [
      'thumbnail' => '(max-width: 767px)'
    ]
  ];

  $data['mediaSlides'] = array_map(function ($item) use ($imageConfig) {
    $item['image']['imageConfig'] = $imageConfig;
    return $item;
  }, $data['mediaSlides']);

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
