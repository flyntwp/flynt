<?php
namespace WPStarterTheme\Modules\Image;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=Image', function ($data) {
  Module::enqueueAssets('Image', [
    [
      'name' => 'objectfit-polyfill',
      'path' => 'vendor/objectfit-polyfill.js',
      'type' => 'script'
    ]
  ]);
});
