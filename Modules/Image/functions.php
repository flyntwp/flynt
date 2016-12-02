<?php
namespace WPStarterTheme\Modules\Image;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;

add_image_size('wps-Image-desktop', 1140, 700);
add_image_size('wps-Image-mobile', 768, 500);

add_filter('WPStarter/modifyModuleData?name=Image', function ($data) {
  Module::enqueueAssets('Image', [
    [
      'name' => 'objectfit-polyfill',
      'path' => 'vendor/objectfit-polyfill.js',
      'type' => 'script'
    ]
  ]);
});
