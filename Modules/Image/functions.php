<?php
namespace WPStarterTheme\Modules\Image;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

add_image_size('wpsImageLg', 1140, 700, true);
add_image_size('wpsImageSm', 768, 500, true);

add_filter('WPStarter/modifyModuleData?name=Image', function ($data) {
  Module::enqueueAssets('Image', [
    [
      'name' => 'objectfit-polyfill',
      'path' => 'vendor/objectfit-polyfill.js',
      'type' => 'script'
    ]
  ]);

  $imageConfig = [
    'default' => 'wpsImageLg',
    'sizes' => [
      'wpsImageSm' => '(max-width: 767px)'
    ]
  ];

  $data['image']['imageConfig'] = $imageConfig;

  return $data;
});
