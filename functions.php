<?php

namespace WPStarterTheme;

use WPStarterTheme\Core;

// TODO check if this is a problem
include_once ABSPATH . 'wp-admin/includes/plugin.php';

if (!is_plugin_active('wp-starter-plugin')) {
  add_filter('template_include', function() {
    $newTemplate = locate_template( array( 'plugin-inactive.php' ) );
		if ( '' != $newTemplate ) {
			return $newTemplate;
		} else {
      return 'WP Starter Plugin not activated! Please activate the plugin and reload the page.';
    }
  });
} else {

  require_once __DIR__ . '/lib/Core.php';

  Core::loadFiles(
    'lib/',
    [
      'Config.php',
      'Helpers.php',
      'Hooks.php',
      'DataFilters.php',
      'Init.php'
    ]
  );

}
