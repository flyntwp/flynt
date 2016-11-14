<?php
namespace WPStarterTheme;

$libIncludes = [
  'lib/Config.php',
  'lib/Helpers.php',
  'lib/DataFilters.php',
  'lib/Hooks.php',
  'lib/Init.php'
];

array_walk($libIncludes, function ($file) {
  if (!locate_template($file, true, true)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'wp-starter-boilerplate'), $file), E_USER_ERROR);
  }
});
