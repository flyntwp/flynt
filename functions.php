<?php

namespace WPStarterTheme;

use WPStarterTheme\Core;

require_once __DIR__ . '/lib/Core.php';

$pluginActive = Core::checkPlugin();

if ($pluginActive) {

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
