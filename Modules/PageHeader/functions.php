<?php

use WPStarterTheme\Helpers\Module;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('PageHeader', [
    [
      'name' => 'slick-carousel',
      // 'cdn' => '', // TODO could add cdn source with this as well
      'path' => 'vendor/slick.js', // uses automatically: Utils::requireAssetUrl(path)
      'dependencies' => [ 'jquery' ], // sub-dependencies
      'type' => 'script' // or style
    ]
  ]);
});

add_filter('WPStarter/modifyModuleData?name=PageHeader', function ($data, $parentData) {
  if (!empty($parentData['post_thumbnail']) && array_key_exists('url', $parentData['post_thumbnail'])) {
    $data['image'] = $parentData['post_thumbnail']['url'];
  }
  return $data;
}, 10, 2);
