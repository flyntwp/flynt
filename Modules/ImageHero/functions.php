<?php
namespace Flynt\Theme\Modules\ImageHero;

use Flynt\Theme\Helpers\Module;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('ImageHero', [
    [
      'name' => 'objectfit-polyfill',
      'path' => 'vendor/objectfit-polyfill.js',
      'type' => 'script'
    ]
  ]);
});
