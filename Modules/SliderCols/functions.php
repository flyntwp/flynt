<?php
namespace WPStarterTheme\Modules\SliderCols;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=SliderCols', function($data) {
  $data['exampleImgSrc'] = Utils::requireAssetUrl('Modules/SliderCols/assets/example.jpg');

  $data['items'] = array_map(function($item) {
    $item['imageUrl'] = $item['image']['sizes']['image-lg'];
    return $item;
  }, $data['items']);
  return $data;
});

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('SliderCols', [
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
