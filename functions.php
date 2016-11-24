<?php

namespace WPStarterTheme;

use WPStarterTheme\Core;

require_once __DIR__ . '/lib/Core.php';

// This needs to happen first.
// Reason:  In case the theme was just activated and the plugin is not active,
//          we still need to run the after_switch_theme action, which is
//          defined here.
Core::setTemplateDirectory();

// Check if the plugin is installed and activated.
// If it isn't, this function redirects the template rendering to use
// plugin-inactive.php instead
$pluginActive = Core::checkPlugin();

if ($pluginActive) {

  Core::loadPhpFiles(
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
