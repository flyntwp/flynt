<?php

namespace WPStarterTheme\Hooks;
/*
* description: Move all page templates into the templates directory
*/

add_action('after_switch_theme', function () {
  $stylesheet = get_option('stylesheet');
  if (basename($stylesheet) !== 'templates') {
    update_option('stylesheet', $stylesheet . '/templates');
  }
});

add_filter('stylesheet', function ($stylesheet) {
  return dirname($stylesheet);
});
