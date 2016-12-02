<?php
namespace WPStarterTheme\Modules\MediaSlider;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=MediaSlider', function ($data) {
  // $data['exampleImgSrc'] = Utils::requireAssetUrl('Modules/MediaSlider/assets/example.jpg');

  // $data['items'] = array_map(function ($item) {
  //   $item['imageUrl'] = $item['image']['url'];
  //   return $item;
  // }, $data['items']);
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
    ],
    [
      'name' => 'jquery-throttle-debounce',
      'path' => 'vendor/jquery-throttle-debounce.js',
      'type' => 'script'
    ]
  ]);
});
