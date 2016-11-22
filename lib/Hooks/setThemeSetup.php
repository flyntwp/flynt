<?php

namespace WPStarterTheme\Hooks;

add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails');
  add_image_size('image-lg', 1400);
  add_image_size('image-md', 1200);
  add_image_size('image-sm', 1024);
  add_image_size('image-xs', 768);
});

register_nav_menus(array(
  'main_navigation' => __('Main Navigation', 'wpstarter'),
  'footer_navigation' => __('Footer Navigation', 'wpstarter')
));
