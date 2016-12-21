<?php

namespace Flynt\Hooks;

add_action('after_setup_theme', function () {
  register_nav_menus(array(
    'main_navigation' => __('Main Navigation', 'Flynt'),
    'footer_navigation' => __('Footer Navigation', 'Flynt')
  ));
});
