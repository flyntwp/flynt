<?php

namespace WPStarterTheme\Hooks;

add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails');
  add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));
});
