<?php

add_filter('WPStarter/modifyModuleData?name=PostList', function($data) {
  $data['posts'] = apply_filters('WPStarterTheme/DataFilters/Posts', [], 5, 'long');
  return $data;
});
