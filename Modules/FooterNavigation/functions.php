<?php

use WPStarterTheme\Helpers\Navigation;

add_filter('WPStarter/modifyModuleData?name=FooterNavigation', function($data) {
  $data['menuItems'] = Navigation::getMenuLinks('footer_navigation');
  return $data;
});
