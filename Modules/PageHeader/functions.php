<?php

use WPStarterTheme\Helpers\Module;

add_filter('WPStarter/modifyModuleData?name=PageHeader', function ($data, $parentData) {
  if (!empty($parentData['post_thumbnail']) && array_key_exists('url', $parentData['post_thumbnail'])) {
    $data['image'] = $parentData['post_thumbnail']['url'];
  }
  return $data;
}, 10, 2);
