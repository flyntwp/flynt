<?php

namespace WPStarterTheme\Hooks;

use WPStarterTheme\Helpers;

add_filter('WPStarter/initModuleConfig', function ($config, $areaName) {
  $moduleClass = Helpers\StringHelpers::camelCaseToKebap($config['name']);
  $areaClass = 'area--' . Helpers\StringHelpers::camelCaseToKebap($areaName);
  $baseClassesArray = ['modules', $areaClass, $moduleClass];
  $baseClasses = join($baseClassesArray, ' ');
  $config['data']['baseClasses'] = $baseClasses;

  return $config;
}, 10, 2);
