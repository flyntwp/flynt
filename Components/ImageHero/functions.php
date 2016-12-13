<?php
namespace Flynt\Components\ImageHero;

use Flynt\Helpers\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ImageHero', [
    [
      'name' => 'objectfit-polyfill',
      'path' => 'vendor/objectfit-polyfill.js',
      'type' => 'script'
    ]
  ]);
});
