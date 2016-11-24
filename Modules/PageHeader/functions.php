<?php

use WPStarterTheme\Helpers\Utils;

add_filter('WPStarter/modifyModuleData?name=PageHeader', function ($data, $parentData) {
  if (!empty($parentData['post_thumbnail']) && array_key_exists('url', $parentData['post_thumbnail'])) {
    $data['image'] = $parentData['post_thumbnail']['url'];
  }
  return $data;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  wp_register_script('slick-carousel', Utils::requireAssetUrl('vendor/slick.js'), ['jquery'], null, true);

  $moduleName = 'PageHeader';
  wp_enqueue_script(
    "WPStarterTheme/Modules/{$moduleName}",
    Utils::requireAssetUrl("Modules/{$moduleName}/script.js"),
    ['jquery', 'slick-carousel'],
    null
  );
});
