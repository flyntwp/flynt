<?php

namespace WPStarterTheme\Hooks;

add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails');
});
