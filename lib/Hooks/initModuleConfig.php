<?php

namespace Flynt\Theme\Hooks;

use Flynt\Theme\Helpers;

add_filter('Flynt/initModuleConfig', function ($config, $areaName) {
  $moduleClass = Helpers\StringHelpers::camelCaseToKebap($config['name']);
  $areaClass = 'area--' . Helpers\StringHelpers::camelCaseToKebap($areaName);
  $baseClassesArray = ['modules', $areaClass, $moduleClass];
  $baseClasses = join($baseClassesArray, ' ');
  $config['data']['baseClasses'] = $baseClasses;

  return $config;
}, 10, 2);
