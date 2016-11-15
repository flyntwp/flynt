<?php
add_filter('WPStarterTheme/DataFilters/MainNavigation', function($data) {
  $data['navigation'] = wp_nav_menu(["echo" => false]);
  return $data;
});
