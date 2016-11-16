<?php

add_filter('WPStarter/modifyModuleData?name=PageHeader', function($data, $parentData) {
  $data['image'] = $parentData['post_thumbnail']['url'];
  return $data;
}, 10, 2);
