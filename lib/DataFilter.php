<?php

namespace WPStarterTheme\DataFilter;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

// Register all helper files for this Project here which are in the Helpers directory.

$dataFilterIncludes = [
  'Posts.php'
];

array_walk($dataFilterIncludes, function ($file) {
  $filePath = 'lib/DataFilter/' . $file;
  if (!locate_template($filePath, true, true)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'wp-starter-boilerplate'), $filePath), E_USER_ERROR);
  }
});
