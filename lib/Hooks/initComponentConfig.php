<?php

namespace Flynt\Hooks;

use Flynt\Helpers;

add_filter('Flynt/initComponentConfig', function ($config, $areaName) {
  $componentClass = Helpers\StringHelpers::camelCaseToKebap($config['name']);
  $areaClass = 'area--' . Helpers\StringHelpers::camelCaseToKebap($areaName);
  $baseClassesArray = ['components', $areaClass, $componentClass];
  $baseClasses = join($baseClassesArray, ' ');
  $config['data']['baseClasses'] = $baseClasses;

  return $config;
}, 10, 2);
