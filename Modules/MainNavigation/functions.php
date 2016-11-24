<?php
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Navigation;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('MainNavigation');
});

add_filter('WPStarter/modifyModuleData?name=MainNavigation', function ($data) {
  $data['menuItems'] = Navigation::getMenuLinks('main_navigation');
  return $data;
});
