<?php
use WPStarterTheme\Helpers\Navigation;

add_filter('WPStarterTheme/DataFilters/MainNavigation', function($data) {
  $data['menuItems'] = Navigation::getMenuLinks('main_navigation');
  return $data;
});
