<?php

namespace WPStarterTheme\Hooks;

add_action('after_setup_theme', function () {
  register_nav_menus(array(
    'main_navigation' => __('Main Navigation', 'WPStarterTheme'),
    'footer_navigation' => __('Footer Navigation', 'WPStarterTheme')
  ));
});
