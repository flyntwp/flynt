<?php

namespace Flynt\Hooks;

add_filter('Flynt/modulePath', function ($modulePath, $moduleName) {
  return get_template_directory() . '/dist/Modules/' . $moduleName;
}, 10, 2);
