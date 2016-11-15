<?php

namespace WPStarterTheme\Hooks;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

use WPStarterTheme;

// Register all helper files for this Project here which are in the Helpers directory.
WPStarterTheme\loadFiles('lib/Hooks/');
