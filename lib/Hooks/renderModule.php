<?php

namespace Flynt\Theme\Hooks;

use Timber\Timber;
use Timber\Loader;
use Twig_SimpleFunction;
use Flynt;

// Render Module
add_filter('Flynt/renderModule', function ($output, $moduleName, $moduleData, $areaHtml) {
  // get index file
  $moduleManager = Flynt\ModuleManager::getInstance();
  $filePath = $moduleManager->getModuleFilePath($moduleName, 'index.twig');

  if (!is_file($filePath)) {
    trigger_error("Template not found: {$filePath}", E_USER_WARNING);
    return $output;
  }

  $addArea = function ($twig) use ($areaHtml) {

    $twig->addFunction(new Twig_SimpleFunction('area', function ($areaName) use ($areaHtml) {
      if (array_key_exists($areaName, $areaHtml)) {
        return $areaHtml[$areaName];
      }
    }));

    return $twig;

  };

  add_filter('get_twig', $addArea);

  $output = Timber::fetch($filePath, $moduleData);

  remove_filter('get_twig', $addArea);

  return $output;
}, 10, 4);
