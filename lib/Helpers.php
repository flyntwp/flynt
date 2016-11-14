<?php

namespace WPStarterTheme\Helpers;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

// Register all helper files for this Project here which are in the Helpers directory.

$helperIncludes = [
  // 'CustomPostTypeLoader.php',
  // 'WPAdminConfig.php',
  'AcfFieldGroupComposer.php'
];

array_walk($helperIncludes, function ($file) {
  $filePath = 'lib/Helpers/' . $file;
  if (!locate_template($filePath, true, true)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'wp-starter-boilerplate'), $filePath), E_USER_ERROR);
  }
});
