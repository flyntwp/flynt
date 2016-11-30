<?php
namespace WPStarterTheme\Modules\SliderCols;

use WPStarterTheme\Helpers\Module;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('SliderCols', [
    [
      'name' => 'normalize',
      'path' => 'vendor/normalize.css',
      'type' => 'style'
    ]
  ]);
});
