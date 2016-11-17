<?php

add_filter('WPStarter/modifyModuleData?name=PostTeasers', function($data) {
  $data['posts'] = apply_filters('WPStarterTheme/DataFilters/Posts', [], 3, 'short');
  return $data;
});
