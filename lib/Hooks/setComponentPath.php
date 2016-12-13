<?php

namespace Flynt\Hooks;

add_filter('Flynt/componentPath', function ($componentPath, $componentName) {
  return get_template_directory() . '/dist/Components/' . $componentName;
}, 10, 2);
