<?php

namespace WPStarterTheme\Hooks;

// Set Config Path
add_filter('WPStarter/configPath', function($filePath, $fileName) {
  return get_template_directory() . '/config/templates/' . $fileName;
}, 10, 2);
