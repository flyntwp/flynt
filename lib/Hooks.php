<?php

namespace WPStarterTheme\Hooks;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

use Pug\Pug;
use WPStarter;
use WPStarterTheme\Helpers\StringHelpers;

// Move all page templates into the templates directory

add_action('after_switch_theme', function () {
  $stylesheet = get_option('stylesheet');
  if (basename($stylesheet) !== 'templates') {
    update_option('stylesheet', $stylesheet . '/templates');
  }
});

add_filter('stylesheet', function ($stylesheet) {
  return dirname($stylesheet);
});

// Set Config Path
add_filter('WPStarter/configPath', function($filePath, $fileName) {
  return get_template_directory() . '/config/templates/' . $fileName;
}, 10, 2);

// Render Module
$pug = new Pug();
add_filter('WPStarter/renderModule', function($output, $moduleName, $moduleData, $areaHtml) use ($pug) {
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

// Enqueue Styles and Scripts
add_action('WPStarter/registerModule', function($modulePath, $moduleName) {
  add_action('wp_enqueue_scripts', function() use ($modulePath, $moduleName) {
    $styleDeps = $moduleName === 'Layout' ? [] : ['WPStarterTheme/Modules/Layout'];
    $styleAbsPath = $modulePath . 'style.css';
    $scriptAbsPath = $modulePath . 'script.js';
    if(is_file($styleAbsPath)) {
      wp_enqueue_style("WPStarterTheme/Modules/{$moduleName}", get_template_directory_uri() . "/Modules/{$moduleName}/style.css", $styleDeps, null);
    }
    if(is_file($scriptAbsPath)) {
      wp_enqueue_script("WPStarterTheme/Modules/{$moduleName}", get_template_directory_uri() . "/Modules/{$moduleName}/script.js", ['jquery'], null, true);
    }
  }, 100);
}, 10, 2);

add_filter('WPStarter/initModuleConfig', function($config, $areaName) {
  $moduleClass = StringHelpers\camelCaseToKebap($config['name']);
  $areaClass = 'area--' . StringHelpers\camelCaseToKebap($areaName);
  $baseClassesArray = ['modules', $areaClass, $moduleClass];
  $baseClasses = join($baseClassesArray, ' ');
  $config['data']['baseClasses'] = $baseClasses;

  return $config;
}, 10, 2);
