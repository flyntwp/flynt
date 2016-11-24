<?php

namespace WPStarterTheme\Hooks;

add_filter('WPStarter/modulePath', function ($modulePath, $moduleName) {
  return get_template_directory() . '/dist/Modules/' . $moduleName;
}, 10, 2);
