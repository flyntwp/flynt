<?php

use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Navigation;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('FooterNavigation');
});

add_filter('WPStarter/modifyModuleData?name=FooterNavigation', function ($data) {
  $data['menuItems'] = Navigation::getMenuLinks('footer_navigation');
  return $data;
});
