<?php

add_filter('WPStarter/modifyModuleData?name=PostTeasers', function($data) {
  $data['posts'] = apply_filters('WPStarterTheme/DataFilters/Posts', [], [
    'postsPerPage' => 5,
    'contentType' => 'long'
  ]);
  return $data;
});
