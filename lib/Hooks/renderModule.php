<?php

namespace WPStarterTheme\Hooks;

use Pug\Pug;
use WPStarter;

// Render Module
$pug = new Pug();
add_filter('WPStarter/renderModule', function ($output, $moduleName, $moduleData, $areaHtml) use ($pug) {
  // get index file
  $moduleManager = WPStarter\ModuleManager::getInstance();
  $filePath = $moduleManager->getModuleFilePath($moduleName, 'index.php.pug');

  if (!is_file($filePath)) {
    trigger_error("Template not found: {$filePath}", E_USER_WARNING);
    return $output;
  }

  $area = function ($areaName) use ($areaHtml) {
    if (array_key_exists($areaName, $areaHtml)) {
      return $areaHtml[$areaName];
    }
  };

  $data = function () use ($moduleData) {
    $args = func_get_args();
    array_unshift($args, $moduleData);
    return WPStarter\Helpers::extractNestedDataFromArray($args);
  };

  return $pug->render($filePath, [
    'data' => $data,
    'area' => $area
  ]);
}, 10, 4);
