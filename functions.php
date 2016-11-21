<?php

namespace WPStarterTheme;

use WPStarterTheme\Core;
use WPStarterTheme\Helpers\Utils;

require_once __DIR__ . '/lib/Core.php';

add_filter('WPStarter/modulePath', function($modulePath, $moduleName) {
  return get_template_directory() . '/dist/Modules/' . $moduleName;
}, 10, 2);

add_action('wp_enqueue_scripts', function() {
    // var_dump(get_template_directory_uri() . "/dist/Modules/{$moduleName}/script.js");die();
  wp_register_script('console-polyfill', Utils::requireAssetUrl('vendor/console.js'), [], null, true);
  wp_register_script('mixwith', Utils::requireAssetUrl('vendor/mixwith.js'), [], null, true);
  wp_register_script('slick-carousel', Utils::requireAssetUrl('vendor/slick.js'), [], null, true);
  wp_register_script('babel-polyfill', Utils::requireAssetUrl('vendor/babel-polyfill.js'), [], null, true);

  wp_enqueue_script('assets/scripts', Utils::requireAssetUrl('assets/scripts/script.js'), ['console-polyfill', 'babel-polyfill', 'mixwith', 'slick-carousel'], null, true);
}, 100);

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
