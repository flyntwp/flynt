<?php
namespace WPStarterTheme\Modules\ImageHero;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_image_size('wpsImageHeroLg', 1140, 700, true);
add_image_size('wpsImageHeroSm', 768, 500, true);

add_filter('WPStarter/modifyModuleData?name=ImageHero', function ($data) {
  Module::enqueueAssets('ImageHero', [
    [
      'name' => 'objectfit-polyfill',
      'path' => 'vendor/objectfit-polyfill.js',
      'type' => 'script'
    ]
  ]);

  $imageConfig = [
    'default' => 'wpsImageHeroLg',
    'sizes' => [
      'wpsImageHeroSm' => '(max-width: 767px)'
    ]
  ];

  $data['image']['imageConfig'] = $imageConfig;

  return $data;
});
