<?php

namespace Flynt\Theme\Hooks;

// Set Config Path
add_filter('Flynt/configPath', function ($filePath, $fileName) {
  return get_template_directory() . '/config/templates/' . $fileName;
}, 10, 2);
