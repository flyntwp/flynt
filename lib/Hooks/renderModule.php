<?php

namespace WPStarterTheme\Hooks;

// use Pug\Pug;
use Timber\Timber;
use Timber\Loader;
use Twig_SimpleFunction;
use WPStarter;

// Render Module
// $pug = new Pug();
// add_filter('WPStarter/renderModule', function ($output, $moduleName, $moduleData, $areaHtml) use ($pug) {
add_filter('WPStarter/renderModule', function ($output, $moduleName, $moduleData, $areaHtml) {
  // get index file
  $moduleManager = WPStarter\ModuleManager::getInstance();
  $filePath = $moduleManager->getModuleFilePath($moduleName, 'index.twig');

  if (!is_file($filePath)) {
    trigger_error("Template not found: {$filePath}", E_USER_WARNING);
    return $output;
  }

  // $area = function ($areaName) use ($areaHtml) {
  //   if (array_key_exists($areaName, $areaHtml)) {
  //     return $areaHtml[$areaName];
  //   }
  // };

  // $data = function () use ($moduleData) {
  //   $args = func_get_args();
  //   array_unshift($args, $moduleData);
  //   return WPStarter\Helpers::extractNestedDataFromArray($args);
  // };

  // $callUserFunc = function ($funcName) {
  //   // TODO add check if funcName is function
  //   call_user_func($funcName);
  // };

  // return $pug->render($filePath, [
  //   'data' => $data,
  //   'callUserFunc' => $callUserFunc,
  //   'area' => $area
  // ]);
  $addArea = function ($twig) use ($areaHtml) {

    $twig->addFunction(new Twig_SimpleFunction('area', function ($areaName) use ($areaHtml){
      if (array_key_exists($areaName, $areaHtml)) {
        return $areaHtml[$areaName];
      }
    }));
    return $twig;
  };
  // $loader = new Loader();
  // $twig = $loader->get_twig();
  add_filter('get_twig', $addArea);

  $output = Timber::fetch($filePath, $moduleData);

  remove_filter('get_twig', $addArea);

  return $output;
}, 10, 4);
