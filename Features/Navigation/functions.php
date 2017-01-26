<?php

namespace Flynt\Features\Navigation;

add_action('after_setup_theme', function () {
  register_nav_menus(array(
    'main_navigation' => __('Main Navigation', 'flynt-theme'),
    'footer_navigation' => __('Footer Navigation', 'flynt-theme')
  ));
});
