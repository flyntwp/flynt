<?php

namespace WPStarterBoilerplate\App\Hooks;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

// Move all page templates into the templates directory

add_action('after_switch_theme', function () {
  $stylesheet = get_option('stylesheet');
  if (basename($stylesheet) !== 'templates') {
    update_option('stylesheet', $stylesheet . '/templates');
  }
});

add_filter('stylesheet', function ($stylesheet) {
  return dirname($stylesheet);
});

add_filter('WPStarter/configPath', function($filePath, $fileName) {
  return get_template_directory() . '/config/templates/' . $fileName;
}, 10, 2);
